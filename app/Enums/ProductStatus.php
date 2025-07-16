<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum ProductStatus: string implements HasColor, HasLabel, HasDescription
{
    case Active = 'active';
    case Inactive = 'inactive';
    case OutOfStock = 'out_of_stock';
    case ComingSoon = 'coming_soon';
    case Discontinued = 'discontinued';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::OutOfStock => 'Out of Stock',
            self::ComingSoon => 'Coming Soon',
            self::Discontinued => 'Discontinued',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Active => 'Product is available for purchase.',
            self::Inactive => 'Product is hidden and not available.',
            self::OutOfStock => 'Product is currently out of inventory.',
            self::ComingSoon => 'Product will be available soon.',
            self::Discontinued => 'Product is no longer available.',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::OutOfStock => 'danger',
            self::ComingSoon => 'info',
            self::Discontinued => 'warning',
        };
    }
}
