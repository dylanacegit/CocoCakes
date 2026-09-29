<?php

namespace App\Models;

use Database\Factories\PetFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'type', 'breed', 'age'])]
class Pet extends Model
{
    /** @use HasFactory<PetFactory> */
    use HasFactory;

    // Cast the age attribute to an integer
    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }

    // A pet belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // A pet can have many orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
