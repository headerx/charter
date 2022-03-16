<x-jet-confirmation-modal wire:model="showDeleteModal">
    <x-slot name="title">
        {{ $modalHeading }}
    </x-slot>

    <x-slot name="content">
        {{ $modalMessage }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('showDeleteModal')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-3" wire:click="destroy" wire:loading.attr="disabled">
            {{ __('Delete') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-confirmation-modal>
