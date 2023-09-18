<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{--            {{ request()->routeIs('notes.show')?__('Note'):__('Trashed Note') }}--}}
            {{$note->trashed()?'Trashed Note':'Note'}}
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        {{--  note --}}
        <div class="py-3 sm:py-6 flex gap-8 items-center w-full justify-between">
            {{--back button--}}
            <div class="justify-self-start">
                <a href="{{ !$note->trashed() ? route('notes.index') : route('trash.index') }}"
                   class="btn btn-lg">
                    {{ __('Back') }}
                </a>
            </div>
            @if(!$note->trashed())
                <div class="flex gap-8">
                    <div class="dark:text-white">
                        <span class="font-semibold">
                            Created at:
                        </span>
                        <span class="dark:text-gray-400">
                            {{$note->created_at->diffForHumans()}}
                        </span>
                    </div>
                    <div class="dark:text-white">
                        <span class="font-semibold">
                            Updated at:
                        </span>
                        <span class="dark:text-gray-400">
                            {{$note->updated_at->diffForHumans()}}
                        </span>
                    </div>
                </div>
                <div class="flex gap-5">
                    {{--edit button--}}
                    <div class="justify-self-end">
                        <a href="{{ route('notes.edit', $note) }}" class="btn btn-lg">
                            {{ __('Edit') }}
                        </a>
                    </div>
                    {{--delete button--}}
                    <div class="justify-self-end">
                        <form id="deleteForm" action="{{ route('notes.destroy', $note) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-danger btn-lg">
                                {{ __('Move to Trash') }}
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($note->trashed())
                <div class="dark:text-white">
                        <span class="font-semibold">
                            Deleted at:
                        </span>
                            <span class="dark:text-gray-400">
                            {{$note->deleted_at->diffForHumans()}}
                        </span>
                </div>
                <div class="flex gap-5">
                    {{--edit button--}}
                    <div class="justify-self-end">
                        <form id="restoreForm" action="{{ route('trash.restore', $note) }}" method="POST">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-lg">
                                {{ __('Restore') }}
                            </button>
                        </form>
                    </div>
                    {{--delete button--}}
                    <div class="justify-self-end">
                        <form id="deleteForm" action="{{ route('trash.destroy', $note) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-danger btn-lg">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-3 sm:py-6 lg:py-8">
            <h3 class="px-6 mb-2 text-gray-900 dark:text-gray-100 text-2xl">
                {{ $note->title }}
            </h3>
            <p class="px-6 mb-3 text-gray-900 dark:text-gray-400 text-lg">
                {{ $note->body }}
            </p>
            <h6 class="px-6 text-gray-900 dark:text-gray-100 text-xs font-semibold">
                {{ ($note->updated_at)->diffForHumans() }}
            </h6>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('deleteForm').addEventListener('submit', function (e) {
        if (!confirm('Are you sure you want to delete?')) {
            e.preventDefault(); // Prevent form submission
        }
    });
</script>
