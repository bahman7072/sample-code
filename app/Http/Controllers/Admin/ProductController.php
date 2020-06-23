<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query();

        if ($keyword = \request('search')){
            $products->where('id', 'LIKE', "%{$keyword}%")
                ->orWhere('title', 'LIKE', "%{$keyword}%");
        }

        $products = $products->latest()->paginate(20);
        return view('admin.products.all', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required'],
            'price' => ['required'],
            'inventory' => ['required'],
            'categories' => ['required'],
        ]);

        $product = auth()->user()->products()->create($data);

        $product->categories()->sync($data['categories']);

        alert()->success('محصول با موفقیت ایجاد شد')->autoclose(4000);
        return redirect(route('products.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required'],
            'price' => ['required'],
            'inventory' => ['required'],
            'categories' => ['required'],
        ]);

        $product->update($data);

        $product->categories()->sync($data['categories']);

        alert()->success('محصول با موفقیت ویرایش شد')->autoclose(4000);
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        alert()->success('محصول "'. $product->title .'" با موفقیت حذف شد')->autoclose(4000);
        return back();
    }
}
