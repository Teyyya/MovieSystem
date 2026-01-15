<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with('genre');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('director', 'like', "${$searchTerm}$");
            });
        }

        if ($request->filled('genre_filter') && $request->genre_filter != '') {
            $query->where('genre_id', $request->genre_filter);
        }

        $movies = $query->latest()->get();
        $genres = Genre::all();

        return view('dashboard', compact('movies', 'genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'nullable|exists:genres,id',
            'release_year' => 'nullable|integer',
            'rating' => 'nullable|numeric',
            'director' => 'nullable|string',
            'synopsis' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('movie-photos', 'public');
            $validated['photo'] = $photoPath;
        }

        Movie::create($validated);

        return redirect()->route('movies.index')->with('success', 'Movie added successfully!');
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'nullable|exists:genres,id',
            'release_year' => 'nullable|integer',
            'rating' => 'nullable|numeric',
            'director' => 'nullable|string',
            'synopsis' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($movie->photo) {
                Storage::disk('public')->delete($movie->photo);
            }

            $photoPath = $request->file('photo')->store('movie-photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $movie->update($validated);

        return redirect()->back()->with('success', 'Movie updated successfully!');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('movies.trash')->with('success', 'Movie deleted successfully!');
    }

    public function trash()
    {
        $movies = Movie::onlyTrashed()->with('genre')->latest('deleted_at')->get();
        $genres = Genre::all();

        return view('trash', compact('movies', 'genres'));
    }

    public function restore($id)
    {
        $movie = Movie::withTrashed()->findOrFail($id);
        $movie->restore();

        return redirect()->route('movies.index')->with('success', 'Movie restored successfully');
    }

    public function forceDelete($id)
    {
        $movie = Movie::withTrashed()->findOrFail($id);

        if ($movie->photo) {
            Storage::disk('public')->delete($movie->photo);
        }

        $movie->forceDelete();
        return redirect()->route('movies.trash')->with('success', 'Movie restored successfully');
    }

    public function export (Request $request)
    {
        $query = Movie::with('genre');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('director', 'like', "${$searchTerm}$");
            });
        }

        if ($request->filled('genre_filter') && $request->genre_filter != '') {
            $query->where('genre_id', $request->genre_filter);
        }

        $movies = $query->latest()->get();

        $filename = 'movie_export_' . date('Y-m-d_His') . '.pdf';

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Movies Export</title>
            <style>
                body {
                    font-family: "Helvetica", Arial, sans-serif;
                    background: #f5f5f5;
                    margin: 0;
                    padding: 30px;
                    color: #111827;
                }

                .container {
                    max-width: 1100px;
                    margin: auto;
                    background: #ffffff;
                    padding: 32px;
                    border-radius: 10px;
                    border: 1px solid #e5e7eb;
                }

                .header {
                    text-align: center;
                    margin-bottom: 28px;
                }

                .header h1 {
                    margin: 0;
                    font-size: 26px;
                    font-weight: 700;
                    color: #111827;
                }

                .header p {
                    margin-top: 8px;
                    font-size: 14px;
                    color: #6b7280;
                }

                .divider {
                    height: 1px;
                    background: #e5e7eb;
                    margin: 24px 0;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                }

                th {
                    background: #f9fafb;
                    color: #374151;
                    padding: 12px;
                    text-align: left;
                    border-bottom: 2px solid #e5e7eb;
                    font-weight: 600;
                }

                td {
                    padding: 12px;
                    border-bottom: 1px solid #e5e7eb;
                    vertical-align: top;
                    color: #374151;
                }

                tr:nth-child(even) {
                    background: #fafafa;
                }

                .badge {
                    display: inline-block;
                    padding: 4px 10px;
                    font-size: 12px;
                    border-radius: 999px;
                    background: #dbeafe;
                    color: #1d4ed8;
                    font-weight: 600;
                }

                .rating {
                    font-weight: 700;
                    color: #2563eb;
                }

                .synopsis {
                    max-width: 320px;
                    color: #6b7280;
                }

                .footer {
                    margin-top: 28px;
                    text-align: center;
                    font-size: 13px;
                    color: #6b7280;
                }

                @media print {
                    body {
                        background: #ffffff;
                        padding: 0;
                    }
                    .container {
                        border-radius: 0;
                        border: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">

                <div class="header">
                    <h1>Movies Report</h1>
                    <p>
                        Exported on ' . date('F d, Y \\a\\t h:i A') . '<br>
                        Total Records: ' . $movies->count() . '
                    </p>
                </div>

                <div class="divider"></div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Year</th>
                            <th>Director</th>
                            <th>Rating</th>
                            <th>Synopsis</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>';

        $number = 1;
        foreach ($movies as $movie) {
            $html .= '<tr>
                <td>' . $number++ . '</td>
                <td>' . htmlspecialchars($movie->title) . '</td>
                <td>
                    <span class="badge">' . htmlspecialchars($movie->genre?->name ?? 'N/A') . '</span>
                </td>
                <td>' . htmlspecialchars($movie->release_year ?? '-') . '</td>
                <td>' . htmlspecialchars($movie->director ?? '-') . '</td>
                <td class="rating">' . htmlspecialchars($movie->rating ?? 'N/A') . '</td>
                <td class="synopsis">' . htmlspecialchars($movie->synopsis ?? '-') . '</td>
                <td>' . $movie->created_at->format('Y-m-d H:i') . '</td>
            </tr>';
        }

        $html .= '</tbody>
                </table>

                <div class="footer">
                    Total Movies: ' . $movies->count() . '<br/>
                    © ' . date('Y') . ' Wave Entertainment. All rights reserved.
                </div>
            </div>
        </body>
        </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}