<x-jet-dialog-modal wire:model="creatingNewLink">
    <x-slot name="title">
        {{ __('New Link') }}
    </x-slot>

    <x-slot name="content">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="domain" value="{{ __('Label') }}" />

            <x-jet-input id="url"
                        type="text"
                        class="block w-full mt-1"
                        wire:model.defer="state.url"
                        {{-- :disabled="! Gate::check('update', $team)"  --}}
                        />

            <x-jet-input-error for="label" class="mt-2" />
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
