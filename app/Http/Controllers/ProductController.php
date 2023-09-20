<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = new Product();

        if ($request->search) {
            $products = $products->where('name', 'LIKE', "%{$request->search}%");
        }

        $products = $products->latest()->paginate(10);

        if (request()->wantsJson()) {
            return ProductResource::collection($products);
        }

        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories  = ProductCategory::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'product_category_id' => 'required|exists:product_categories,id',
        //     'image' => 'nullable|image',
        //     'buying_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        //     'selling_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        //     'unit' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     // return 'yo';
        //     Log::error($validator->errors()->all()[0]);
        //     return redirect()->back()->with('error', $validator->errors()->all()[0]);
        // }

        if ($request->validate()) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating product.');
        }

        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products', 'public');
        }


        $product = Product::create([
            'name' => $request->name,
            'product_category_id' => $request->product_category_id,
            'image' => $image_path,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'unit' => $request->unit
        ]);

        if (!$product) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating product.');
        }
        return redirect()->route('products.index')->with('success', 'Success, your product has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories  = ProductCategory::all();

        return view('products.edit', ['categories' => $categories])->with('product', $product);
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
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image',
            'buying_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'selling_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'unit' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::error($validator->errors()->all()[0]);
            return redirect()->back()->with('error', $validator->errors()->all()[0]);
        }

        $image_path = $product->image;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $image_path = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'product_category_id' => $request->product_category_id ?? $product->product_category_id,
            'image' => $image_path,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'unit' => $request->unit
        ]);

        if (!$product) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while updating product.');
        }
        return redirect()->route('products.index')->with('success', 'Success, your product has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create category
     */
    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_categories,name'
        ]);

        $category = ProductCategory::create([
            'name' => $request->name
        ]);

        if (!$category) {
            return redirect()->back()->with('error', 'Sorry, there was a problem while creating category.');
        }
        return redirect()->back()->with('success', 'Success, your category has been created.');
    }
}
