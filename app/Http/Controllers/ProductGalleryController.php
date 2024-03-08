<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $gallery = ProductGallery::where('product_id', $product->id)->get();


        // Mengirimkan data produk ke tampilan
        return view('pages.gallery.index', [
            'gallery' => $gallery,
            'product' => $product,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('pages.gallery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGalleryRequest $request, Product $product)
    {
        $files = $request->file('files');

        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $path = $file->store('assets/gallery', 'public');

                // Dapatkan URL dari file yang disimpan
                $url = url('') . Storage::url($path);

                ProductGallery::create([
                    'product_id' => $product->id,
                    'image_url' => $url
                ]);
            }
        }
        return redirect()->route('product.gallery.index', $product->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGalleryRequest $request, ProductGallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product, $gallery)
    {
        $gallery = ProductGallery::findOrFail($gallery);
        $gallery->delete();
        return redirect()->route('product.gallery.index', ['product' => $product]);
    }
}
