
<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Movies</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $movies->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-6 w-6 text-blue-600 dark:text-blue-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="7.5" r="1.5"></circle>
                            <circle cx="12" cy="16.5" r="1.5"></circle>
                            <circle cx="7.5" cy="12" r="1.5"></circle>
                            <circle cx="16.5" cy="12" r="1.5"></circle>

                            <path d="M22 12h-2"></path>
                        </svg>
                    </div>

                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Genres</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $genres->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-green-600 dark:text-green-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7a2 2 0 012-2h4l2 2h6a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                        </svg>
                    </div>

                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Average Rating</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ number_format($movies->avg('rating'), 1) }}</h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-purple-600 dark:text-purple-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 17.25l-5.19 3.03 1.39-5.97L3 9.75l6.03-.52L12 3.75l2.97 5.48L21 9.75l-5.2 4.56 1.39 5.97L12 17.25z" />
                        </svg>
                    </div>

                </div>
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">
                <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add New Movie</h2>

                    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter movie title" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('title')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Director</label>
                            <input type="text" name="director" value="{{ old('director') }}" placeholder="Enter director" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('director')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Release Year</label>
                            <input type="number" name="release_year" value="{{ old('release_year') }}" placeholder="e.g., 2023" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('release_year')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Rating</label>
                            <input type="number" step="0.1" max="10" min="0" name="rating" value="{{ old('rating') }}" placeholder="e.g., 8.5" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('rating')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Genre</label>
                            <select name="genre_id" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="">Select a genre</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }} ({{ $genre->description ?? 'No description' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('genre_id')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Synopsis</label>
                            <textarea name="synopsis" placeholder="Enter synopsis" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('synopsis') }}</textarea>
                            @error('synopsis')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Movie Poster Upload -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Movie Poster (Optional)
                            </label>

                            <input
                                type="file"
                                name="photo"
                                accept="image/jpeg,image/png,image/jpg"
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm
                                    file:mr-4 file:rounded-md file:border-0
                                    file:bg-blue-600 file:px-4 file:py-2
                                    file:text-sm file:font-medium file:text-white
                                    hover:file:bg-blue-700
                                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                                    dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100
                                    dark:file:bg-blue-500 dark:hover:file:bg-blue-600"
                            >

                            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                JPG or PNG format. Maximum file size: 2MB.
                            </p>

                            @error('photo')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Add Movie
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-xl border border-neutral-200
                    bg-gradient-to-b from-neutral-50 via-white to-neutral-100 p-6
                    dark:border-neutral-700 dark:from-neutral-900 dark:via-neutral-800 dark:to-neutral-900">

                    {{-- Header + Export --}}
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                                Search & Filter Movies
                            </h2>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                                Find movies by title or genre
                            </p>
                        </div>

                        <form method="GET" action="{{ route('movies.export') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="genre_filter" value="{{ request('genre_filter') }}">

                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg
                                    bg-blue-600 px-4 py-2 text-sm font-medium text-white
                                    transition hover:bg-blue-700
                                    focus:ring-2 focus:ring-blue-500/40">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export PDF
                            </button>
                        </form>
                    </div>

                    {{-- Filters --}}
                    <form action="{{ route('movies.index') }}" method="GET"
                        class="grid gap-4 md:grid-cols-3">

                        {{-- Search --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Search Movie
                            </label>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by movie title"
                                class="w-full rounded-lg border border-neutral-300 bg-white
                                    px-4 py-2 text-sm text-neutral-900 placeholder-neutral-400
                                    focus:border-blue-500 focus:outline-none
                                    focus:ring-2 focus:ring-blue-500/30
                                    dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
                            >
                        </div>

                        {{-- Genre --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Filter by Genre
                            </label>
                            <select
                                name="genre_filter"
                                class="w-full rounded-lg border border-neutral-300 bg-white
                                    px-4 py-2 text-sm text-neutral-900
                                    focus:border-blue-500 focus:outline-none
                                    focus:ring-2 focus:ring-blue-500/30
                                    dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
                            >
                                <option value="">All Genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}"
                                        {{ request('genre_filter') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-end gap-2">
                            <button
                                type="submit"
                                class="flex-1 rounded-lg bg-blue-600 px-4 py-2
                                    text-sm font-medium text-white
                                    transition hover:bg-blue-700
                                    focus:ring-2 focus:ring-blue-500/40">
                                Apply
                            </button>

                            <a
                                href="{{ route('movies.index') }}"
                                class="rounded-lg border border-neutral-300 px-4 py-2
                                    text-sm font-medium text-neutral-700
                                    transition hover:bg-neutral-100
                                    dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                                Clear
                            </a>
                        </div>

                    </form>
                </div>

                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Movie List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Poster</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Genre</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Year</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Rating</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Director</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Synopsis</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($movies as $movie)
                                    <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            @if($movie->photo)
                                                <img
                                                    src="{{ Storage::url($movie->photo) }}"
                                                    alt="{{ $movie->title }}"
                                                    class="h-12 w-12 rounded-lg object-cover
                                                        ring-2 ring-blue-500/40"
                                                >
                                            @else
                                                <div
                                                    class="flex h-12 w-12 items-center justify-center rounded-lg
                                                        bg-blue-100 text-sm font-semibold text-blue-700
                                                        ring-2 ring-blue-300
                                                        dark:bg-blue-900/30 dark:text-blue-300 dark:ring-blue-700"
                                                >
                                                    {{ strtoupper(substr($movie->title, 0, 2)) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-neutral-900 dark:text-neutral-100">{{ $movie->title }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $movie->genre?->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $movie->release_year ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $movie->rating ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $movie->director ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400 max-w-md">{{ $movie->synopsis ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <button onclick="editMovie({{ $movie->id }}, '{{ $movie->title }}', {{ $movie->genre_id ?? 'null' }}, '{{ $movie->release_year }}', '{{ $movie->rating }}', '{{ $movie->director }}', '{{ addslashes($movie->synopsis) }}', '{{ $movie->photo}}')"
                                                     class="text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('movies.destroy', $movie) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this movie?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No movies found. Add your first movie above!
                                        </td>
                                        </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editMovieModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-2xl rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Movie</h2>

            <form id="editMovieForm" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                        <input type="text" id="edit_title" name="title" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Director</label>
                        <input type="text" id="edit_director" name="director" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Release Year</label>
                        <input type="number" id="edit_release_year" name="release_year" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Rating</label>
                        <input type="number" step="0.1" max="10" min="0" id="edit_rating" name="rating" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Genre</label>
                        <select id="edit_genre_id" name="genre_id" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Select a genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Synopsis</label>
                        <textarea id="edit_synopsis" name="synopsis" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"></textarea>
                    </div>
                </div>

                <div id="currentPhotoPreview" class="mb-3"></div>
                <input
                    type="file"
                    id="edit_photo"
                    name="photo"
                    accept="image/jpeg,image/png,image/jpg"
                    class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-700
                        file:mr-4 file:rounded-md file:border-0
                        file:bg-blue-50 file:px-4 file:py-2
                        file:text-sm file:font-medium file:text-blue-700
                        hover:file:bg-blue-100
                        focus:border-blue-500 focus:outline-none
                        focus:ring-2 focus:ring-blue-500/30
                        dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200
                        dark:file:bg-blue-900/30 dark:file:text-blue-400"
                />

                <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                    Leave empty to keep the current movie poster. JPG or PNG. Maximum file size: 2MB.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditMovieModal()"
                            class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                        Update Movie
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editMovie(id, title, genreId, release_year, rating, director, synopsis, photo) {
            document.getElementById('editMovieModal').classList.remove('hidden');
            document.getElementById('editMovieModal').classList.add('flex');
            document.getElementById('editMovieForm').action = `/movies/${id}`;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_director').value = director;
            document.getElementById('edit_release_year').value = release_year;
            document.getElementById('edit_rating').value = rating;
            document.getElementById('edit_genre_id').value = genreId || '';
            document.getElementById('edit_synopsis').value = synopsis;

            const photoPreview = document.getElementById('currentPhotoPreview');
            if (photo) {
                photoPreview.innerHTML = `
                    <div class="flex items-center gap-3 rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                        <img src="/storage/${photo}" alt="${name}" class="h-16 w-16 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Current Photo</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Upload new photo to replace</p>
                        </div>
                    </div>
                `;
            } else {
                photoPreview.innerHTML = `
                    <div class="rounded-lg border border-dashed border-neutral-300 p-4 text-center dark:border-neutral-600">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">No photo uploaded</p>
                    </div>
                `;
            }
        }

        function closeEditMovieModal() {
            document.getElementById('editMovieModal').classList.add('hidden');
            document.getElementById('editMovieModal').classList.remove('flex');
        }
    </script>
</x-layouts.app>
