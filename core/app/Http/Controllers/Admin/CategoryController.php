<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Categories';
        $categories = Category::orderBy('name')->get();

        return view('admin.category.index',compact('pageTitle','categories'));
    }

    public function store(Request $request, $id = 0)
    {

    }

    public function changeStatus($id)
    {
        return Category::changeStatus($id);
    }
}
