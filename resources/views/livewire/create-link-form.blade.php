<x-jet-dialog-modal wire:model="creatingNewLink">
    <x-slot name="title">
        {{ __('Add Bookmark') }}
    </x-slot>

    <x-slot name="content">
        <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
            <x-jet-label class="w-10 mt-4 mr-2" for="Label" value="{{ __('Name') }}" />

            <x-jet-input id="label"
                        type="text"
                        class="block w-full mt-1 rounded-none"
                        wire:model="state.label"
                        {{-- :disabled="! Gate::check('update', $team)"  --}}
                        />

            <x-jet-input-error for="label" class="mt-2" />
        </div>
        <div class="inline-flex flex-row justify-between w-full sm:col-span-4">
            <x-jet-label class="w-10 mt-4 mr-2" for="url" value="{{ __('URL  ') }}" />

            <x-jet-input id="url"
                        type="text"
                        class="w-full mt-1"
                        wire:model.defer="state.url"
                        {{-- :disabled="! Gate::check('update', $team)"  --}}
                        />

            <x-jet-input-error for="url" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('creatingNewLink', false)" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-3" wire:click="createLink" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
