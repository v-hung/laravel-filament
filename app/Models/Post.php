<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $casts = [
        'status' => Status::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PostCategory::class);
    }
}
