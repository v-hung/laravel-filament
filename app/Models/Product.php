<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
        'slug',
        'description',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class);
    }
}
