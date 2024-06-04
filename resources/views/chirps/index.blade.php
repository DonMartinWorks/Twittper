<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

        @session('success')
            <div x-data="{ isOpen: true }" x-show="isOpen" x-cloak x-init="setTimeout(() => isOpen = false, 3000)"
                class="relative flex flex-col sm:flex-row sm:items-center bg-gray-300 dark:bg-green-700 shadow rounded-md py-5 pl-6 pr-8 sm:pr-6 mb-3 mt-3">
                <div class="flex flex-row items-center border-b sm:border-b-0 w-full sm:w-auto pb-4 sm:pb-0">
                    <div class="text-green-300 dark:text-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>

                    <div class="text-sm font-medium ml-3 dark:text-gray-100">
                        {{ __('Success!') }}&#8226;
                    </div>
                </div>

                <div class="text-sm tracking-wide text-gray-500 dark:text-white mt-4 sm:mt-0 sm:ml-4">
                    {{ $value }}
                </div>

                <div @click="isOpen = false"
                    class="absolute sm:relative sm:top-auto sm:right-auto ml-auto right-4 top-4 text-gray-400 hover:text-gray-800 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        @endsession

        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <textarea name="message" placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('message') }}</textarea>

            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
        </form>

        <div
            class="my-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y dark:divide-cyan-400 dark:border-cyan-400 border-2">
            @forelse ($chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>

                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 dark:text-white font-semibold">
                                    {{ $chirp->user->name }}
                                </span>

                                <small class="ml-2 text-sm text-gray-600 dark:text-cyan-400">
                                    {{-- $chirp->created_at->format('j M Y, g:i a') --}}
                                    {{ $chirp->created_at->diffForHumans() }}
                                </small>

                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-gray-600 dark:text-cyan-200"> &middot;
                                        {{ __('edited') }}</small>
                                @endunless
                            </div>

                            @if ($chirp->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('chirps.destroy', $chirp)"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>

                        <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{{ $chirp->message }}</p>
                    </div>
                </div>
            @empty
                <div class="p-6 dark:bg-gray-900">
                    <div class="text-lg text-gray-800 dark:text-gray-100">
                        {{ __('No chirps found') }}.
                    </div>
                </div>
            @endforelse

            <div class="w full text-center p-2">
                {{ $chirps->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
