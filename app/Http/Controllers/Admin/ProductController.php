<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
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

    public function create(Store $store)
    {
        $stores = $store->all(['id','name']);
        return view('admin.products.create', compact('stores'));
    }

    // Renomeado de 'product' para 'store'
    public function store(ProductFormRequest $request, Store $store)
    {
        $store = $store->findOrFail($request->store);

        $store->products()->create($request->except('store')); 

        return redirect()->route('admin.products.index');
    }

    public function edit(string $product)
    {
        $product = $this->product->findOrFail($product);

        return view('admin.products.edit', compact('product'));
    }

    public function update(string $product, ProductFormRequest $request)
    {
        $product = $this->product->findOrFail($product);

        $product->update($request->all());

        return redirect()->back();
    }

    public function destroy(string $product)
    {
        $product = $this->product->findOrFail($product);
        $product->delete();

        return redirect()->back();
    }
}
