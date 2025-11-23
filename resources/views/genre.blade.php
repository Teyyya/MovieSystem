<x-layouts.app :title="__('Genres')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl bg-gradient-to-br from-neutral-50 to-neutral-100 dark:from-neutral-900 dark:to-neutral-800 p-6 shadow-lg">

        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300 border border-green-200 dark:border-green-700 shadow-sm">
                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800 shadow-xl">
            <div class="flex h-full flex-col p-8">

                <!-- Add New Genre Form -->
                <div class="mb-8 rounded-xl border border-neutral-200 bg-gradient-to-r from-neutral-50 to-neutral-100 p-8 dark:border-neutral-700 dark:from-neutral-900/50 dark:to-neutral-800/50 shadow-md">
                    <h2 class="mb-6 text-2xl font-bold text-neutral-900 dark:text-neutral-100 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Genre
                    </h2>

                    <form action="{{ route('genres.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="mb-3 block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter genre name" required
                                       class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100 transition-all duration-200 shadow-sm hover:shadow-md">
                                @error('name')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-3 block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Description</label>
                                <input type="text" name="description" value="{{ old('description') }}" placeholder="Enter description (optional)"
                                       class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100 transition-all duration-200 shadow-sm hover:shadow-md">
                                @error('description')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-3 text-sm font-semibold text-white transition-all duration-200 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Genre
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Genres Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-6 text-2xl font-bold text-neutral-900 dark:text-neutral-100 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Genre List
                    </h2>
                    <div class="overflow-x-auto rounded-lg shadow-lg">
                        <table class="w-full min-w-full bg-white dark:bg-neutral-800">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-gradient-to-r from-neutral-50 to-neutral-100 dark:border-neutral-700 dark:from-neutral-900/50 dark:to-neutral-800/50">
                                    <th class="px-6 py-4 text-center text-sm font-bold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-neutral-700 dark:text-neutral-300">Name</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-neutral-700 dark:text-neutral-300">Description</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-neutral-700 dark:text-neutral-300">Movies Count</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($genres as $genre)
                                    <tr class="transition-all duration-200 hover:bg-gradient-to-r hover:from-neutral-50 hover:to-neutral-100 dark:hover:from-neutral-800/50 dark:hover:to-neutral-700/50 hover:shadow-md">
                                        <td class="px-6 py-4 text-center text-sm text-neutral-600 dark:text-neutral-400 font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-center text-sm text-neutral-900 dark:text-neutral-100 font-semibold">{{ $genre->name }}</td>
                                        <td class="px-6 py-4 text-center text-sm text-neutral-600 dark:text-neutral-400">{{ $genre->description ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center text-sm text-neutral-600 dark:text-neutral-400 font-medium">{{ $genre->movies_count }}</td>
                                        <td class="px-6 py-4 text-center text-sm space-x-2">
                                            <button onclick="editGenre({{ $genre->id }}, '{{ addslashes($genre->name) }}', '{{ addslashes($genre->description ?? '') }}')"
                                                    class="text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </button>
                                            <span class="mx-2 text-neutral-400">|</span>
                                            <form action="{{ route('genres.destroy', $genre) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this genre?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            <svg class="w-12 h-12 mx-auto mb-4 text-neutral-300 dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            No genres found. Add your first genre above!
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

    <!-- Edit Genre Modal -->
    <div id="editGenreModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="w-full max-w-2xl rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-800 shadow-2xl transform scale-95 transition-all duration-300 ease-out" style="animation: modalIn 0.3s ease-out forwards;">
            <h2 class="mb-6 text-2xl font-bold text-neutral-900 dark:text-neutral-100 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Genre
            </h2>

            <form id="editGenreForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-3 block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Name</label>
                        <input type="text" id="edit_name" name="name" required
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100 transition-all duration-200 shadow-sm hover:shadow-md">
                    </div>

                    <div>
                        <label class="mb-3 block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Description</label>
                        <input type="text" id="edit_description" name="description"
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100 transition-all duration-200 shadow-sm hover:shadow-md">
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-4">
                    <button type="button" onclick="closeEditModal()"
                            class="rounded-lg border border-neutral-300 px-6 py-3 text-sm font-semibold text-neutral-700 transition-all duration-200 hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white transition-all duration-200 hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Genre
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>

    <script>
        function editGenre(id, name, description) {
            document.getElementById('editGenreModal').classList.remove('hidden');
            document.getElementById('editGenreModal').classList.add('flex');
            document.getElementById('editGenreForm').action = `/genres/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
        }

        function closeEditModal() {
            document.getElementById('editGenreModal').classList.add('hidden');
            document.getElementById('editGenreModal').classList.remove('flex');
        }
    </script>
</x-layouts.app>