<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{

    public function index()
    {
        $pageTitle = 'Shipping Method';
        $methods = ShippingMethod::latest()->paginate(getPaginate());

        return view('admin.shipping_method', compact('pageTitle', 'methods'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|unique:brands|string|max:255',
            'price' => 'required|min:0',
        ]);

        if ($id) {
            $method = ShippingMethod::findOrFail($id);
            $notify[] = ['success', 'Shipping method updated successfully'];
        } else {
            $method = new ShippingMethod();
            $notify[] = ['success', 'Shipping method added successfully'];
        }


        $method->name = $request->name;
        $method->price = $request->price;
        $method->save();

        return redirect()->route('admin.shipping.index')->withNotify($notify);
    }

    public function status($id)
    {
        return ShippingMethod::changeStatus($id);
    }
}
