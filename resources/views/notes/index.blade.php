<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if(Route::currentRouteName() == 'notes.index')
                {{ __('Notes') }}
            @elseif(Route::currentRouteName() == 'trash.index')
                {{ __('Trash') }}
            @endif
        </h2>
    </x-slot>

    {{--  flash message  --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('success'))
                <div
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 overflow-hidden shadow-sm sm:rounded-lg relative"
                    role="alert">
                    <span class="block sm:inline">{{ session()->get('success') }}</span>
                </div>
            @elseif(session()->has('error'))
                <div
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 overflow-hidden shadow-sm sm:rounded-lg relative"
                    role="alert">
                    <span class="block sm:inline">{{ session()->get('error') }}</span>
                </div>
            @endif
        </div>
    </div>


    {{-- add notes--}}
    @if(Route::currentRouteName() == 'notes.index')
        <div class="max-w-7xl mx-auto py-3 sm:py-6 lg:py-8 sm:px-6 lg:px-8">
            <a href="{{ route('notes.create') }}" class="btn btn-lg">
                {{ __('Add Note') }}
            </a>
        </div>
    @endif

    {{--  notes  --}}
    <ul class="space-y-5">
        @forelse($notes as $note)
            <li class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-3 sm:py-6 lg:py-8">
                    <h3 class="px-6 mb-2 text-gray-900 dark:text-gray-100 text-2xl">
                        @if(Route::currentRouteName() == 'notes.index')
                            <a href="{{ route('notes.show', $note) }}">{{ $note->title }}</a>
                        @elseif(Route::currentRouteName() == 'trash.index')
                            <a href="{{ route('trash.show', $note) }}">{{ $note->title }}</a>
                        @endif
                    </h3>
                    <p class="px-6 mb-3 text-gray-900 dark:text-gray-400 text-lg">
                        {{ Str::of($note->body)->limit('60',('...')) }}
                    </p>
                    <h6 class="px-6 text-gray-900 dark:text-gray-100 text-xs font-semibold">
                        {{ ($note->updated_at)->diffForHumans() }}
                    </h6>
                </div>
            </li>
        @empty
            <li class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-3 sm:py-6 lg:py-8">
                    @if(Route::currentRouteName() == 'notes.index')
                        <h3 class="px-6 mb-2 text-gray-900 dark:text-gray-100 text-2xl">
                            {{ __('No notes found.') }}
                        </h3>
                    @elseif(Route::currentRouteName() == 'trash.index')
                        <h3 class="px-6 mb-2 text-gray-900 dark:text-gray-100 text-2xl">
                            {{ __('No trashed notes found.') }}
                        </h3>
                    @endif
                </div>
            </li>
        @endforelse
    </ul>

    {{--  pagination navigation  --}}
    <div class="max-w-7xl mx-auto py-3 sm:py-6 lg:py-8 sm:px-6 lg:px-8">
        {{ $notes->links() }}
    </div>

</x-app-layout>
