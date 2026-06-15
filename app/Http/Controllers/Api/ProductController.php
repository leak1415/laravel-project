<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get()->map(function (Product $product) {
            return $this->transformProduct($product);
        });

        return response()->json([
            'success' => true,
            'data' => $products,
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        if (! is_array($validated)) {
            return $validated;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated)->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'data' => $this->transformProduct($product),
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $this->transformProduct($product),
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $validated = $this->validateProduct($request);

        if (! is_array($validated)) {
            return $validated;
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);
        $product->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.',
            'data' => $this->transformProduct($product),
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.',
        ], Response::HTTP_OK);
    }

    private function validateProduct(Request $request): array|\Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $validator->validated();
    }

    private function transformProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'category_id' => $product->category_id,
            'name' => $product->name,
            'image' => $product->image,
            'image_url' => $product->image_url,
            'price' => $product->price,
            'stock' => $product->stock,
            'is_active' => $product->is_active,
            'created_at' => $product->created_at?->toISOString(),
            'updated_at' => $product->updated_at?->toISOString(),
            'category' => $product->relationLoaded('category') && $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'description' => $product->category->dec,
                'is_active' => $product->category->is_active,
            ] : null,
        ];
    }
}
