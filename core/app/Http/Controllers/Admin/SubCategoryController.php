<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Categories';
        $subcategories = SubCategory::orderBy('name')->paginate(getPaginate());
        $categories = Category::active()->get();

        return view('admin.sub-category.index',compact('pageTitle','subcategories', 'categories'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);


        if ($id) {
            $subcategory = SubCategory::findOrFail($id);
            $notify[] = ['success', 'Sub Category updated successfully'];
        } else {
            $subcategory = new SubCategory();
            $notify[] = ['success', 'Sub Category added successfully'];
        }

        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category_id;
        $subcategory->status = $request->status ? Status::ENABLE : Status::DISABLE;
        $subcategory->save();

        return redirect()->route('admin.subcategory.index')->withNotify($notify);
    }

    public function status($id)
    {
        return SubCategory::changeStatus($id);
    }
}
