<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private Product $product)
    {
    }

    public function index()
    {
        $products = $this->product->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create(Store $store, Category $category)
    {
        $stores = $store->all(['id','name']);
        $categories = $category->all(['id','name']);

        return view('admin.products.create', compact('stores', 'categories'));
    }

    // Renomeado de 'product' para 'store'
    public function store(ProductFormRequest $request, Store $store)
    {
        $store = auth()->store;

        $product = $store->products()->create($request->except('store', 'categories')); 

        if ($request->categories) $product->categories()->sync($request->categories);

        return redirect()->route('admin.products.index');
    }

    public function edit(string $product, Store $store, Category $category)
    {
        $stores = $store->all(['id','name']);
        
        $categories = $category->all(['id','name']);
        $product = $this->product->findOrFail($product);

        return view('admin.products.edit', compact('product', 'stores', 'categories'));
    }

    public function update(string $product, ProductFormRequest $request)
    {
        $product = $this->product->findOrFail($product);

        $product->update($request->except('categories'));

        $product->categories()->sync($request->categories);

        return redirect()->back();
    }

    public function destroy(string $product)
    {
        $product = $this->product->findOrFail($product);
        $product->delete();

        return redirect()->back();
    }
}
