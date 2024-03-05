<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        // filter product by id
        $id = $request->input('id');
        // filter product by limit
        $limit = $request->input('limit');
        // filter product by name
        $name = $request->input('id');
        // filter product by show_product
        $show_product = $request->input('show_product');

        if ($id) {
            // relasi agar muncul category dan gallery di response json
            $category = ProductCategory::with(['products'])->find($id);

            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data kategori produk berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data kategori produk gagal diambil',
                    404
                );
            }
        }

        $category = ProductCategory::query();
        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data list kategori produk berhasil diambil'
        );
    }
}
