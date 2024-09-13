<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //direct user home page
    public function userHome($categoryId = null)
    {
        $product = Product::select('products.id', 'products.name', 'products.image', 'products.price', 'products.description', 'categories.name as categories_name')
            ->leftJoin('categories', 'categories.id', 'products.category_id')
            // Search by name
            ->when(request('searchKey'), function ($query) {
                $query = $query->where('products.name', 'like', '%' . request('searchKey') . '%');
            })
            // Search by category
            ->when($categoryId != null, function ($query) use ($categoryId) {
                $query->where('products.category_id', $categoryId);
            })
            // MaxPrice and Min Price
            ->when(request('minPrice') != null && request('maxPrice') != null, function ($query) {
                $query = $query->whereBetween('products.price', [request('minPrice'), request('maxPrice')]);
            })
            // MinPrice
            ->when(request('minPrice') != null && request('maxPrice') == null, function ($query) {
                $query = $query->where('products.price', '>=', request('minPrice'));
            })
            // Max Price
            ->when(request('minPrice') == null && request('maxPrice') != null, function ($query) {
                $query = $query->where('products.price', '<=', request('maxPrice'));
            })
            // Sorting
            ->when(request('sortingType'), function($query){
                $sortRule = explode(',', request('sortingType'));
                $sortName = 'products.' . $sortRule[0];
                $sortType = $sortRule[1];
                $query = $query->orderBy($sortName, $sortType);
            })->get();
            // ->orderBy('products.created_at', 'desc')->get();
        $categories = Category::get();
        return view('user.home.index', compact('product', 'categories'));
    }
}
