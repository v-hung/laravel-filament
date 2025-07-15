<?php

namespace App\Models;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title',
        'slug',
        'description',
    ];

    protected $casts = [
        'status' => ContentStatus::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PostCategory::class);
    }
}
