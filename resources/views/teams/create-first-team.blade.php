<x-guest-layout>

    @if(!Gate::allows('create', Laravel\Jetstream\Jetstream::newTeamModel()))
    <div role="alert" class="text-red-700 bg-red-100 border border-t-0 border-red-400 rounded-b">
        <div class="px-4 py-6 font-bold text-white bg-red-500 rounded-t">
            <h2>
                {{ __('Membership is required.') }}
            </h2>
        </div>
        <div class="px-4 py-3 sm:px-6 lg:px-28 lg:py-28">

            <p>
            <div class="px-4 py-3 text-indigo-900 bg-gray-100 border-t-4 border-indigo-500 rounded-b shadow-md"
                role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="w-6 h-6 mr-4 text-indigo-500 fill-current"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                        </svg></div>
                    <div>
                        <p class="font-bold">Invited to join an organization?</p>
                        <p class="text-sm">Go <a href="#" class="underline">here</a> for instructions on how to accept
                            the invitation.</p>
                    </div>
                </div>
            </div>
            </p>
            <p class="p-4">
                {{ __('You must be an upgraded member to access this part of the application.') }}
            </p>
        </div>
        <div class="flex items-center justify-end p-2">
            <a href="{{ route('guest-iframe.billing') }}">
                <x-jet-secondary-button>
                    {{ __('Upgrade') }}
                </x-jet-secondary-button>
            </a>
        </div>
    </div>
    @else
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Organization') }}
        </h2>
    </x-slot>
    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @livewire('teams.create-team-form')
        </div>
    </div>
    @endif
</x-guest-layout>
