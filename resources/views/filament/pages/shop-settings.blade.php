<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
        <div>
            <x-filament::button type="submit" size="sm" wire:target="save"
                wire:loading.attr="disabled"
                :loading-indicator="true"
            >
                {{__('filament-panels::resources/pages/edit-record.form.actions.save.label')}}
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
