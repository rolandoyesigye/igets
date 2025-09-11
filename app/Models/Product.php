<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "price",
        "original_price",
        "brand",
        "category",
        "image",
        "sku",
        "stock_quantity",
        "is_active",
        "is_featured",
        "discount_percentage",
        "specifications",
        "condition",
        "warranty",
    ];

    protected $casts = [
        "price" => "decimal:2",
        "original_price" => "decimal:2",
        "is_active" => "boolean",
        "is_featured" => "boolean",
        "specifications" => "array",
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically update is_active based on stock quantity
        static::saving(function ($product) {
            if ($product->stock_quantity <= 0) {
                $product->is_active = false;
            }
        });
    }

    /**
     * Check if product is out of stock
     */
    public function isOutOfStock()
    {
        return $this->stock_quantity <= 0;
    }

    /**
     * Check if product is in stock
     */
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Get stock status text
     */
    public function getStockStatusAttribute()
    {
        if ($this->isOutOfStock()) {
            return "Out of Stock";
        }

        return "In Stock";
    }

    /**
     * Get stock status color class
     */
    public function getStockStatusColorAttribute()
    {
        if ($this->isOutOfStock()) {
            return "text-red-600";
        }

        return "text-green-600";
    }

    /**
     * Get the formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return "UGX " . number_format($this->price, 0);
    }

    /**
     * Get the formatted original price
     */
    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price
            ? "UGX " . number_format($this->original_price, 0)
            : null;
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
            return round(
                (($this->original_price - $this->price) /
                    $this->original_price) *
                    100,
            );
        }
        return 0;
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where("is_active", true);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where("is_featured", true);
    }

    /**
     * Scope for products by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where("category", $category);
    }

    /**
     * Scope for in-stock products
     */
    public function scopeInStock($query)
    {
        return $query->where("stock_quantity", ">", 0);
    }

    /**
     * Scope for out-of-stock products
     */
    public function scopeOutOfStock($query)
    {
        return $query->where("stock_quantity", "<=", 0);
    }

    /**
     * Scope for case-insensitive search
     */
    public function scopeSearch($query, $searchTerm)
    {
        // If search term is empty or null, return the query as-is
        if (empty(trim($searchTerm))) {
            return $query;
        }

        return $query->where(function ($q) use ($searchTerm) {
            $searchLower = strtolower(trim($searchTerm));
            $q->whereRaw("LOWER(name) LIKE ?", ["%{$searchLower}%"])
                ->orWhereRaw("LOWER(description) LIKE ?", ["%{$searchLower}%"])
                ->orWhereRaw("LOWER(brand) LIKE ?", ["%{$searchLower}%"])
                ->orWhereRaw("LOWER(category) LIKE ?", ["%{$searchLower}%"]);
        });
    }
}
