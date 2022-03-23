<x-guest-layout>

    <div role="alert" class="text-indigo-700 bg-indigo-100 border border-indigo-400 rounded h-1/2">
        <div class="px-4 py-6 font-bold text-white bg-indigo-500">
            <h2>
                {{ __('Joining an existing Organization.') }}
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
                        <p class="text-sm">To join an existing organization, click the "accept invitation" button in the team invitation mail.</p>

                        <p class="text-sm">Didn't get a team invitation mail? Ask a member of an existing organization to invite you to their team.</p>
                    </div>
                </div>
            </div>
            </p>
            <p class="p-4">
                Why not try  <a class="underline" href="{{ route('teams.create') }}">creating</a> an organization of your own?
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
</x-guest-layout>
