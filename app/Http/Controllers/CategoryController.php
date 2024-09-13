<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    // Category Page
    public function list(){
        $categories = Category::orderBy('created_at', 'desc')->paginate(3);
        return view('admin.category.list', compact('categories'));
    }

    // Create Category
    public function create(Request $request){
        $this->checkValidationStatus($request);
        Category::create([
            'name' => $request->categoryName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Alert::success('Category Create', 'Category Created successfull!');
        toast('Category Create Successful!', 'success');

        return back();
    }

    // Category Update Page
    public function updatePage($id){
        $category = Category::where('id', $id)->first();
        return view('admin.category.update', compact('category'));
    }

    // Update Category
    public function update($id, Request $request){
        $this->checkValidationStatus($request);
        Category::where('id', $id)->update([
            'name' => $request->categoryName,
            'updated_at' => Carbon::now()
        ]);
        toast('Category Update Successful!', 'success');
        return to_route('category#list');
    }

    // Check Validation For Create/Update Category
    public function checkValidationStatus(Request $request){
        $request->validate([
            'categoryName' => 'required',
        ]);
    }

    // Delete Category
    public function delete($id){
        Category::find($id)->delete();
        // Alert::success('Category Delete', 'Category Deleted Successfull!');
        toast('Delete Successful!', 'success');
        return back();
    }
}
