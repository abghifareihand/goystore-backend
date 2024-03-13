<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        // filter product by id
        $id = $request->input('id');
        // filter product by limit
        $limit = $request->input('limit');
        // filter product by name
        $name = $request->input('name');
        // filter product by description
        $description = $request->input('description');
        // filter product by tags
        $tags = $request->input('tags');
        // filter product by categories
        $categories = $request->input('categories');

        // filter product by price from to
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if ($id) {
            // relasi agar muncul category dan gallery di response json
            $product = Product::with(['category', 'galleries'])->find($id);

            if ($product) {
                return response()->json([
                    'code' => 200,
                    'success' => true,
                    'message' => 'Data produk berhasil diambil',
                    'data' => $product
                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'success' => false,
                    'message' => 'Data produk gagal diambil',
                ], 404);
            }
        }

        $product = Product::with(['category', 'galleries']);
        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        if ($description) {
            $product->where('description', 'like', '%' . $name . '%');
        }

        if ($tags) {
            $product->where('tags', 'like', '%' . $name . '%');
        }

        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $product->where('price', '<=', $price_to);
        }

        if($categories)
            $product->where('categories_id', $categories);

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Data list produk berhasil diambil',
            'data' => $product->get(),
        ]);
    }
}
