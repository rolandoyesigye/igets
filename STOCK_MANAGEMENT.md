# Stock Management Functionality

## Overview

This implementation provides automatic stock management for products in the iGETS e-commerce system. When a product's stock quantity reaches 0, it automatically becomes "Out of Stock" and the add to cart functionality is disabled.

## Features

### 1. Automatic Stock Status Management

- **Zero Stock Detection**: Products with `stock_quantity <= 0` are automatically marked as inactive
- **Stock Status Display**: Shows "Out of Stock", "Low Stock (X left)", or "In Stock (X available)"
- **Color-coded Status**: Red for out of stock, orange for low stock, green for in stock

### 2. Cart Protection

- **Stock Validation**: Cannot add products to cart if they're out of stock
- **Quantity Limits**: Cannot add more items than available in stock
- **Real-time Validation**: Checks stock availability before adding to cart

### 3. Admin Features

- **Automatic Deactivation**: Products with zero stock are automatically deactivated
- **Stock Status Indicators**: Admin panel shows clear stock status with color coding
- **Manual Command**: `php artisan products:update-out-of-stock` to update existing products

## Implementation Details

### Product Model Methods

```php
// Check if product is out of stock
$product->isOutOfStock(); // Returns true if stock_quantity <= 0

// Check if product is in stock
$product->isInStock(); // Returns true if stock_quantity > 0

// Get stock status text
$product->stock_status; // Returns "Out of Stock", "Low Stock (X left)", or "In Stock (X available)"

// Get stock status color class
$product->stock_status_color; // Returns CSS color classes for styling
```

### Automatic Behavior

1. **Model Boot Method**: Automatically sets `is_active = false` when `stock_quantity <= 0`
2. **Controller Validation**: Prevents creating/updating products with zero stock as active
3. **Cart Service**: Validates stock availability before adding to cart

### Views Updated

- **Home Page**: Shows stock status and disables add to cart for out-of-stock items
- **Category Pages**: Laptops, Accessories, Phones pages show stock status
- **Product Detail Page**: Shows detailed stock information and quantity limits
- **Admin Panel**: Enhanced stock status display with auto-deactivation indicators

## Usage

### For Admins

1. **Adding Products**: Set stock quantity - if 0, product will be automatically inactive
2. **Updating Stock**: When stock reaches 0, product becomes inactive automatically
3. **Manual Update**: Run `php artisan products:update-out-of-stock` to update existing products

### For Customers

1. **Product Display**: Out-of-stock products show "Out of Stock" instead of "Add to Cart"
2. **Cart Protection**: Cannot add out-of-stock items to cart
3. **Quantity Limits**: Cannot add more items than available stock

## Commands

```bash
# Update existing products with zero stock to be inactive
php artisan products:update-out-of-stock
```

## Testing

The functionality includes comprehensive tests covering:
- Automatic deactivation of zero-stock products
- Stock status attributes
- Cart validation for out-of-stock items
- Quantity limit enforcement

Run tests with: `php artisan test tests/Feature/StockManagementTest.php`
