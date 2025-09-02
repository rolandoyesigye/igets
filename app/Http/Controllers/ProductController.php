<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ToastrNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use ToastrNotifications;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'sku' => 'nullable|string|unique:products,sku',
            'stock_quantity' => 'nullable|integer|min:0',
            'condition' => 'nullable|string|in:new,used,refurbished',
            'warranty' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Generate SKU if not provided
        if (empty($data['sku'])) {
            $data['sku'] = 'SKU-' . strtoupper(Str::random(8));
        }

        // Calculate discount percentage if original price is provided
        if (!empty($data['original_price']) && $data['original_price'] > $data['price']) {
            $data['discount_percentage'] = round((($data['original_price'] - $data['price']) / $data['original_price']) * 100);
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Automatically set is_active to false if stock is 0
        if (isset($data['stock_quantity']) && $data['stock_quantity'] <= 0) {
            $data['is_active'] = false;
        }

        Product::create($data);

        return $this->toastSuccessRedirect('Product created successfully!', 'products.index');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'stock_quantity' => 'nullable|integer|min:0',
            'condition' => 'nullable|string|in:new,used,refurbished',
            'warranty' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Calculate discount percentage if original price is provided
        if (!empty($data['original_price']) && $data['original_price'] > $data['price']) {
            $data['discount_percentage'] = round((($data['original_price'] - $data['price']) / $data['original_price']) * 100);
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Automatically set is_active to false if stock is 0
        if (isset($data['stock_quantity']) && $data['stock_quantity'] <= 0) {
            $data['is_active'] = false;
        }

        $product->update($data);

        return $this->toastSuccessRedirect('Product updated successfully!', 'products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return $this->toastSuccessRedirect('Product deleted successfully!', 'products.index');
    }
}
