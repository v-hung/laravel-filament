<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    use CreateRecord\Concerns\Translatable {
        updatedActiveLocale as translatableUpdateActiveLocale;
    }

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }

    public function updatedActiveLocale(string $newActiveLocale): void
    {
        $this->translatableUpdateActiveLocale($newActiveLocale);
        // $this->form->callAfterStateHydrated();
    }
}
