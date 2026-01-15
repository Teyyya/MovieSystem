<x-layouts.app :title="__('Movie Trash')">
    <div class="space-y-6">

        {{-- Success Message --}}
        @if(session('success'))
            <div
                class="rounded-lg bg-green-50 p-4 text-sm text-green-700 border border-green-200
                       dark:bg-green-900/40 dark:text-green-300 dark:border-green-800"
                x-data="{ show:true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                    Movie Trash
                </h1>
                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                    Restore or permanently delete movies
                </p>
            </div>

            <a href="{{ route('movies.index') }}"
               class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Back to Movies
            </a>
        </div>

        {{-- Summary Card --}}
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-5 shadow-sm
                    dark:border-blue-800 dark:bg-blue-900/30">
            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                Movies in Trash
            </p>
            <p class="mt-1 text-3xl font-bold text-blue-900 dark:text-blue-100">
                {{ $movies->count() }}
            </p>
        </div>

        {{-- Table Container --}}
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white
                    dark:border-neutral-700 dark:bg-neutral-900">
            <div class="p-6">

                <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                    Deleted Movies
                </h2>

                @if($movies->isEmpty())
                    <div class="flex items-center justify-center rounded-lg border border-dashed
                                border-neutral-300 p-12 dark:border-neutral-700">
                        <div class="text-center">
                            <h3 class="text-sm font-medium text-neutral-600 dark:text-neutral-400">
                                Trash is empty
                            </h3>
                            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-500">
                                No deleted movies found.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <table class="w-full text-left">
                            <thead class="bg-neutral-100 border-b border-neutral-200
                                         dark:bg-neutral-800 dark:border-neutral-700">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-semibold text-neutral-600 dark:text-neutral-300">Poster</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-neutral-600 dark:text-neutral-300">Title</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-neutral-600 dark:text-neutral-300">Genre</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-neutral-600 dark:text-neutral-300">Year</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-neutral-600 dark:text-neutral-300">Rating</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-neutral-600 dark:text-neutral-300">Deleted At</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-neutral-600 dark:text-neutral-300 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @foreach($movies as $movie)
                                    <tr class="transition hover:bg-neutral-50 dark:hover:bg-neutral-800">

                                        {{-- Poster --}}
                                        <td class="px-4 py-3">
                                            @if($movie->photo)
                                                <img
                                                    src="{{ Storage::url($movie->photo) }}"
                                                    class="h-10 w-10 rounded-lg object-cover
                                                           ring-2 ring-blue-500/40"
                                                >
                                            @else
                                                <div class="flex h-10 w-10 items-center justify-center rounded-lg
                                                            bg-blue-100 text-sm font-semibold text-blue-700
                                                            ring-2 ring-blue-300
                                                            dark:bg-blue-900/30 dark:text-blue-300 dark:ring-blue-700">
                                                    {{ strtoupper(substr($movie->title, 0, 2)) }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Title --}}
                                        <td class="px-4 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                            {{ $movie->title }}
                                        </td>

                                        {{-- Genre --}}
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                            {{ $movie->genre?->name ?? 'N/A' }}
                                        </td>

                                        {{-- Year --}}
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">
                                            {{ $movie->release_year ?? '-' }}
                                        </td>

                                        {{-- Rating --}}
                                        <td class="px-4 py-3 text-sm font-semibold text-blue-600 dark:text-blue-400">
                                            {{ $movie->rating ?? 'N/A' }}
                                        </td>

                                        {{-- Deleted At --}}
                                        <td class="px-4 py-3 text-sm text-neutral-500 dark:text-neutral-400">
                                            {{ $movie->deleted_at->format('M d, Y') }}
                                            <div class="text-xs">
                                                {{ $movie->deleted_at->format('h:i A') }}
                                            </div>
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-4 py-3">
                                            <div class="flex justify-end gap-2">

                                                {{-- Restore --}}
                                                <form method="POST" action="{{ route('movies.restore', $movie->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Restore this movie?')"
                                                        class="rounded-lg bg-green-600 px-3 py-1.5 text-sm
                                                               font-medium text-white hover:bg-green-700">
                                                        Restore
                                                    </button>
                                                </form>

                                                {{-- Delete Forever --}}
                                                <form method="POST" action="{{ route('movies.force-delete', $movie->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Permanently delete this movie? This cannot be undone!')"
                                                        class="rounded-lg bg-red-600 px-3 py-1.5 text-sm
                                                               font-medium text-white hover:bg-red-700">
                                                        Delete Forever
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-layouts.app>
