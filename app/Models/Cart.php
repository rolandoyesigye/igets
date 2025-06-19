<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the product that belongs to this cart item
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns this cart item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the total price for this cart item
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Boot the model and set session_id if not provided
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cart) {
            if (empty($cart->session_id)) {
                $cart->session_id = session()->getId();
            }
        });
    }
}
