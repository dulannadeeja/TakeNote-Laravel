<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Note') }}
        </h2>
    </x-slot>

    {{--  create notes form  --}}
    <div class="max-w-7xl mx-auto py-3 sm:py-6 lg:py-8 sm:px-6 lg:px-8">
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-md p-6">
                {{-- Title Field --}}
                <!-- Name -->
                <div class="mb-6">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" placeholder="{{ __('Enter the title') }}" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                {{-- Body Field --}}
                <div class="mb-6">
                    <x-input-label for="body" :value="__('Body')" />
                    <x-textarea id="body" rows="10" placeholder="{{__('Write your note here.')}}" class="block mt-1 w-full" name="body" :value="old('body')" />
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                </div>

                {{-- Submit Button --}}
                <x-primary-button>
                    {{ __('Save Note') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
