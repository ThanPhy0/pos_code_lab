<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Create Product View
    public function create()
    {
        $categories = Category::get();
        return view('admin.product.create', compact('categories'));
    }

    // Create New Product
    public function createProduct(Request $request)
    {
        $this->checkProductValidation($request, 'create');
        $productData = $this->getProductData($request);

        if ($request->hasFile('image')) {
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/product/', $fileName);
            $productData['image'] = $fileName;
        }

        Product::create($productData);

        toast('Product Create Successful!', 'success');
        return back();
    }

    private function getProductData($request)
    {
        return [
            'name' => $request->name,
            'category_id' => $request->categoryID,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description
        ];
    }

    private function checkProductValidation($request, $action)
    {
        $rule = [
            'name' => 'required|unique:products,name,' . $request->productId,
            'categoryID' => 'required',
            'price' => 'required',
            'stock' => 'required|max:999',
            'description' => 'required'
        ];

        $rule['image'] = $action == 'create' ? 'required' : '';

        $request->validate($rule);
    }

    // Product List View
    public function productList($amt = 'default')
    {
        $product = Product::select('categories.name as categories_name', 'products.id', 'products.image', 'products.name', 'products.price', 'products.stock', 'products.description')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['products.name'], 'like', '%' . request('searchKey') . '%');
            });
        if ($amt != 'default') {
            $product = $product->where('stock', '<=', '3');
        }
        $product = $product->orderBy('products.created_at', 'desc')->get();
        return view('admin.product.list', compact('product'));
    }

    // View
    public function view(){

    }

    // Update Page
    public function updatePage($id){
        $categories = Category::get();
        $product = Product::where('id', $id)->first();
        return view('admin.product.edit', compact('categories', 'product'));
    }

    // Update Product
    public function update(Request $request, $id){
        $this->checkProductValidation($request, 'update');
        $product = $this->getProductData($request);

        if($request->hasFile('image')){
            if(file_exists(public_path() . '/product/' . $request->oldPhoto)){
                unlink(public_path() . '/product/' . $request->oldPhoto);
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/product/', $fileName);
            $product['image'] = $fileName;
        }else{
            $product['image'] = $request->oldPhoto;
        }

        Product::where('id', $id)->update($product);
        toast('Product Update Successful!', 'success');
        return to_route('product#list');
    }

    // Delete
    public function delete($id){
        Product::where('id', $id)->delete();
        toast('Delete Successful!', 'success');
        return back();
    }
}
