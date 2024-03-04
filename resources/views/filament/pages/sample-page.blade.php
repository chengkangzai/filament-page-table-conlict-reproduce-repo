<x-filament-panels::page @class(['fi-resource-create-record-page'])>
    <x-filament-panels::form :wire:key="$this->getId() . '.forms.' . $this->getFormStatePath()" wire:submit="create">
        {{ $this->form }}
    </x-filament-panels::form>

    @if (false)
        {{ $this->table }}

        <div wire:poll.5s="pollNewPosTransaction" wire:poll.visible></div>
    @endif
</x-filament-panels::page>
