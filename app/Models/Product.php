<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name',
    'slug',
    'description',
    'image',
    'options',
])]
class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Cast the options attribute to an array
    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }

    // A product belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // A product can have many orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
