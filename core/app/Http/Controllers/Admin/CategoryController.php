<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Categories';
        $categories = Category::orderBy('name')->paginate(getPaginate());

        return view('admin.category.index',compact('pageTitle','categories'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($id) {
            $category = Category::findOrFail($id);
            $notify[] = ['success', 'Category updated successfully'];
        } else {
            $category = new Category();
            $notify[] = ['success', 'Category added successfully'];
        }
        if ($request->hasFile('image')) {
            try {
                $old = $category->image;
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'), $old);
            } catch (\Exception $e) {
                $notify[] = ['error', 'Could not upload your image'];
                return back()->withNotify($notify);
            }
        }

        $category->name = $request->name;
        $category->status = $request->status ? Status::ENABLE : Status::DISABLE;
        $category->save();

        return redirect()->route('admin.category.index')->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return Category::changeStatus($id);
    }
}
