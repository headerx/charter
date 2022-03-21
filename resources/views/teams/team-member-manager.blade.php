<div>
    @if (Gate::check('addTeamMember', $team))
    <x-jet-section-border />

    <!-- Add Organization Member -->
    <div class="mt-10 sm:mt-0">
        <x-jet-form-section submit="addTeamMember">
            <x-slot name="title">
                {{ __('Add Organization Member') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add a new organization member to your organization, allowing them to collaborate with you.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    <div class="max-w-xl text-sm text-gray-600">
                        {{ __('Please provide the email address of the person you would like to add to this
                        organization.') }}
                    </div>
                </div>

                <!-- Member Email -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" type="email" class="block w-full mt-1"
                        wire:model.defer="addTeamMemberForm.email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>

                <!-- Role -->
                @if (count($this->roles) > 0)
                <div class="col-span-6 lg:col-span-4">
                    <x-jet-label for="role" value="{{ __('Role') }}" />
                    <x-jet-input-error for="role" class="mt-2" />

                    <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                        @foreach ($this->roles as $index => $role)
                        <button type="button"
                            class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                            wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                            <div
                                class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div
                                        class="text-sm text-gray-600 {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                        {{ $role->name }}
                                    </div>

                                    @if ($addTeamMemberForm['role'] == $role->key)
                                    <svg class="w-5 h-5 ml-2 text-green-400" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @endif
                                </div>

                                <!-- Role Description -->
                                <div class="mt-2 text-xs text-left text-gray-600">
                                    {{ $role->description }}
                                </div>
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Added.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Add') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </div>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
    <x-jet-section-border />

    <!-- Organization Member Invitations -->
    <div class="mt-10 sm:mt-0">
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Pending Organization Invitations') }}
            </x-slot>

            <x-slot name="description">
                {{ __('These people have been invited to your organization and have been sent an invitation email. They
                may join the organization by accepting the email invitation.') }}
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    @foreach ($team->teamInvitations as $invitation)
                    <div class="flex items-center justify-between">
                        <div class="text-gray-600">{{ $invitation->email }}</div>

                        <div class="flex items-center">
                            @if (Gate::check('removeTeamMember', $team))
                            <!-- Cancel Organization Invitation -->
                            <button class="ml-6 text-sm text-red-500 cursor-pointer focus:outline-none"
                                wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                {{ __('Cancel') }}
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </x-slot>
        </x-jet-action-section>
    </div>
    @endif

    @if ($team->users->isNotEmpty())
    <x-jet-section-border />

    <!-- Manage Organization Members -->
    <div class="mt-10 sm:mt-0">
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Organization Members') }}
            </x-slot>

            <x-slot name="description">
                {{ __('All of the people that are part of this organization.') }}
            </x-slot>

            <!-- Organization Member List -->
            <x-slot name="content">
                <div class="space-y-6">
                    @foreach ($team->users->sortBy('name') as $user)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}"
                                alt="{{ $user->name }}">
                            <div class="ml-4">{{ $user->name }}</div>
                        </div>

                        <div class="grid grid-rows-6 sm:flex sm:items-center">


                            <a id="{{ $user->email }}" href="#{{ $user->email  }}" class="text-sm text-gray-400 underline">
                                {{ $user->email }}
                            </a>

                            <!-- Manage Organization Member Role -->
                            @if (
                            Gate::check('addTeamMember', $team) &&
                            Laravel\Jetstream\Jetstream::hasRoles() &&
                            Gate::check('update', \App\Charter::membershipInstance($team, $user))
                            )

                            <button class="ml-2 text-sm text-gray-400 underline"
                                wire:click="manageRole('{{ $user->id }}')">
                                {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                            </button>
                            @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                            <div class="ml-2 text-sm text-gray-400">
                                {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                            </div>
                            @endif

                            <!-- Leave Organization -->
                            @if ($this->user->id === $user->id)
                            <button class="ml-6 text-sm text-red-500 cursor-pointer"
                                wire:click="$toggle('confirmingLeavingTeam')">
                                {{ __('Leave') }}
                            </button>

                            <!-- Remove Organization Member -->
                            @elseif (
                            Gate::check('addTeamMember', $team) &&
                            Laravel\Jetstream\Jetstream::hasRoles() &&
                            Gate::check('delete', \App\Charter::membershipInstance($team, $user))
                            )
                            <button class="ml-6 text-sm text-red-500 cursor-pointer"
                                wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                {{ __('Remove') }}
                            </button>

                            <button class="ml-6 text-sm text-indigo-500 cursor-pointer">
                                <a href="{{ route('impersonate', $user->uuid) }}">{{ __('Manage') }} / {{ _('Assist') }}</a>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </x-slot>
        </x-jet-action-section>
    </div>
    @endif

    <!-- Role Management Modal -->
    <x-jet-dialog-modal wire:model="currentlyManagingRole">
        <x-slot name="title">
            {{ __('Manage Role') }}
        </x-slot>

        <x-slot name="content">
            <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                @foreach ($this->roles as $index => $role)
                <button type="button"
                    class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                    wire:click="$set('currentRole', '{{ $role->key }}')">
                    <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                        <!-- Role Name -->
                        <div class="flex items-center">
                            <div class="text-sm text-gray-600 {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                {{ $role->name }}
                            </div>

                            @if ($currentRole == $role->key)
                            <svg class="w-5 h-5 ml-2 text-green-400" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @endif
                        </div>

                        <!-- Role Description -->
                        <div class="mt-2 text-xs text-gray-600">
                            {{ $role->description }}
                        </div>
                    </div>
                </button>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="updateRole" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Leave Organization Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingLeavingTeam">
        <x-slot name="title">
            {{ __('Leave Organization') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to leave this organization?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="leaveTeam" wire:loading.attr="disabled">
                {{ __('Leave') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Remove Organization Member Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('Remove Organization Member') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this person from the organization?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
