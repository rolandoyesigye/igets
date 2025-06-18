<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'brand',
        'category',
        'image',
        'sku',
        'stock_quantity',
        'is_active',
        'is_featured',
        'discount_percentage',
        'specifications',
        'condition',
        'warranty',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'specifications' => 'array',
    ];

    /**
     * Get the formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'UGX ' . number_format($this->price, 0);
    }

    /**
     * Get the formatted original price
     */
    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? 'UGX ' . number_format($this->original_price, 0) : null;
    }

    /**
     * Get the discount amount
     */
    public function getDiscountAmountAttribute()
    {
        if ($this->original_price && $this->price < $this->original_price) {
            return $this->original_price - $this->price;
        }
        return 0;
    }

    /**
     * Get the discount percentage
     */
    public function getCalculatedDiscountPercentageAttribute()
    {
        if ($this->original_price && $this->price < $this->original_price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for products by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
