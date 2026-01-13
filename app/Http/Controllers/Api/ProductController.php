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
        //ambil produk berdasarkan ID
        $product = Product::find($id);

        //jika produk tidak ditemukan
        if (!$product) {
            return response()->json([
                'message' => "Produk tidak ditemukan"
            ], 404);
        }

        //ambil jumlah yang mau dijual
        $qty = $request->input('qty');

        //validasi sederhana
        if ($qty <= 0) {
            return response()->json([
                'message' => 'Jumlah jual harus lebih dari 0'
            ], 400);
        }
        //cek stok cukup atau tidak
        if ($product->stock < $qty) {
            return response()->json([
                'message' => 'Stok tidak cukup'
            ], 400);
        }

        // kurangi stok
        $product->stock = $product->stock - $qty;
        $product->save();

        //response sukses
        return response()->json([
            'message' => 'Produk berhasil dijual',
            'sisa_stok' => $product->stock
        ]);
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
