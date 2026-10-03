<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'product_id',
    'pet_id',
    'customer_name',
    'email',
    'pet_name',
    'pet_type',
    'flavor',
    'size',
    'pickup_date',
    'special_instructions',
    'status',
])]
class Order extends Model
{
    use HasFactory;

    // Cast the pickup_date attribute to a date
    protected function casts(): array
    {
        return [
            'pickup_date' => 'date',
        ];
    }

    // An order belongs to a user, product, and pet
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // An order belongs to a product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // An order belongs to a pet
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
