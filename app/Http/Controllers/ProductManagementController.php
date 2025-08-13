<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductManagementController extends Controller
{
    /**
     * Display the product management page with tabs.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Store a new product category.
     */
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simulate creating category (using dummy data for now)
            $category = [
                'id' => rand(1000, 9999),
                'name' => $request->name,
                'description' => $request->description,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category. Please try again.'
            ], 500);
        }
    }

    /**
     * Update an existing product category.
     */
    public function updateCategory(Request $request, $categoryId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simulate updating category
            $category = [
                'id' => $categoryId,
                'name' => $request->name,
                'description' => $request->description,
                'updated_at' => now()->format('Y-m-d H:i:s')
            ];

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!',
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category. Please try again.'
            ], 500);
        }
    }

    /**
     * Delete a product category.
     */
    public function destroyCategory($categoryId)
    {
        try {
            // Simulate deleting category
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category. Please try again.'
            ], 500);
        }
    }

    /**
     * Store a new product.
     */
    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'barcode' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simulate creating product
            $product = [
                'id' => rand(1000, 9999),
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'cost' => $request->cost,
                'stock_quantity' => $request->stock_quantity,
                'barcode' => $request->barcode,
                'status' => $request->status,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product. Please try again.'
            ], 500);
        }
    }

    /**
     * Update an existing product.
     */
    public function updateProduct(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'barcode' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simulate updating product
            $product = [
                'id' => $productId,
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'cost' => $request->cost,
                'stock_quantity' => $request->stock_quantity,
                'barcode' => $request->barcode,
                'status' => $request->status,
                'updated_at' => now()->format('Y-m-d H:i:s')
            ];

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product. Please try again.'
            ], 500);
        }
    }

    /**
     * Delete a product.
     */
    public function destroyProduct($productId)
    {
        try {
            // Simulate deleting product
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product. Please try again.'
            ], 500);
        }
    }
}
