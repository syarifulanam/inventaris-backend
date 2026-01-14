<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use App\Traits\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;

    public function sell(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->errorResponse('User not found', 404);
        }

        $qty = $request->input('qty');

        if ($qty <= 0) {
            return $this->errorResponse('minimal qty is one', 400);
        }

        if ($product->stock < $qty) {
            return $this->errorResponse('stock is not enough', 400);
        }

        $product->stock = $product->stock - $qty;
        $product->save();

        return $this->successResponse($product, 'Product created successfully');
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $product = Product::orderBy('created_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse($product, 'Product list retrieved successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create($validated);

        return $this->successResponse($product, 'Product created successfully');
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return $this->successResponse($product, 'Product retrieved successfully');
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);
        return $this->successResponse($product, 'Product updated successfully');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
