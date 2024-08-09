<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class ManageBrandController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Brands';
        $brands = Brand::orderBy('name')->paginate(getPaginate());

        return view('admin.brand.index',compact('pageTitle','brands'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($id) {
            $brand = Brand::findOrFail($id);
            $notify[] = ['success', 'Brand updated successfully'];
        } else {
            $brand = new Brand();
            $notify[] = ['success', 'Brand added successfully'];
        }


        $brand->name = $request->name;
        $brand->status = $request->status ? Status::ENABLE : Status::DISABLE;
        $brand->save();

        return redirect()->route('admin.brand.index')->withNotify($notify);
    }

    public function status($id)
    {
        return Brand::changeStatus($id);
    }
}
