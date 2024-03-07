<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $category = ProductCategory::paginate(10);
        // return view('category.index', [
        //     'category' => $category,

        // ]);
        $category = ProductCategory::withCount('products')->paginate(10);
        return view('pages.category.index', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {
        $data = $request->all();
        ProductCategory::create($data);

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {
        return view('pages.category.edit', [
            'item' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        $data = $request->all();
        $category->update($data);

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        $category->delete();
        return redirect()->route('category.index');
    }
}
