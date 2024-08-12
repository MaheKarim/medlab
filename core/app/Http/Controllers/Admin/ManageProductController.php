<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ManageProductController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Products';
        $products = Product::latest()->paginate(getPaginate());
        return view('admin.product.index', compact('pageTitle', 'products'));
    }

    public function create()
    {
        $pageTitle  = "Add New Product";
        $brands     = Brand::active()->orderBy('name')->get();
        $categories = Category::active()->orderBy('name')->get();

        return view('admin.product.create', compact('pageTitle', 'brands', 'categories'));
    }

    public function store(Request $request, $id = 0)
    {
        $isRequired = $id ? 'nullable' : 'required';

        $request->validate([
            'name'                   => 'required|max:255',
            'strength'               => 'nullable|max:255',
            'generic_name'           => 'nullable|max:255',
            'brand_id'               => 'required|exists:brands,id',
            'category_id'            => 'required|exists:categories,id',
            'subcategory_id'         => 'required|exists:sub_categories,id',
            'product_sku'            => 'nullable|string',
            'quantity'               => 'required|integer|gt:0',
            'price'                  => 'required|numeric|gt:0',
            'discount'               => 'nullable|numeric|min:0',
            'discount_type'          => 'required|in:1,2',
            'summary'                => 'required',
            'description'            => 'nullable',
            'benefits'               => 'nullable',
            'service'                => 'nullable',
            'features'               => 'nullable|array|min:1',
            'image'                  => [$isRequired, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'gallery'                => "$isRequired|array|min:0|max:6",
            'gallery.*'              => [$isRequired, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);

        if ($request->discount) {
            if ($request->discount_type == 1) {
                $discount = $request->price - $request->discount;
            } else {
                $discount = $request->price - (($request->price * $request->discount) / 100);
            }

            if ($discount <= 0) {
                $notify[] = ['error', 'Discount price can\'t be grater than main price'];
                return back()->withNotify($notify);
            }
        }
        $isFileRequired = 'required_if:file_type,1';
        if ($id) {
            $product = Product::findOrFail($id);

            $message       = "Product updated successfully";
            $imageToRemove = $request->old ? array_values(removeElement($product->gallery, $request->old)) : $product->gallery;

            if ($imageToRemove != null && count($imageToRemove)) {
                foreach ($imageToRemove as $singleImage) {
                    fileManager()->removeFile(getFilePath('productGallery') . '/' . $singleImage);
                }
                $product->gallery = removeElement($product->gallery, $imageToRemove);
            }

        } else {

            $product = new Product();
            $message = "Product added successfully";
        }


        if ($request->hasFile('image')) {
            try {
                $product->image = fileUploader($request->image, getFilePath('product'), getFileSize('product'), @$product->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your product image'];
                return back()->withNotify($notify);
            }
        }

        $gallery = $id ? $product->gallery : [];

        if ($request->hasFile('gallery')) {
            foreach ($request->gallery as $singleImage) {
                try {
                    $gallery[] = fileUploader($singleImage, getFilePath('productGallery'), getFileSize('productGallery'));
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your product gallery image'];
                    return back()->withNotify($notify);
                }
            }
        }

        $product->name           = $request->name;
        $product->strength       = $request->strength;
        $product->generic_name   = $request->generic_name;
        $product->brand_id       = $request->brand_id;
        $product->category_id    = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->product_sku    = $request->product_sku;
        $product->quantity       = $request->quantity;
        $product->price          = $request->price;
        $product->discount       = $request->discount ?? 0;
        $product->discount_type  = $request->discount_type;
        $product->summary        = $request->summary;
        $product->benefits       = $request->benefits;
        $product->description    = $request->description;
        $product->service        = $request->service;
        $product->gallery        = $gallery;
        $product->save();

        $notify[] = ["success", $message];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle  = "Edit Product";
        $product    = Product::findOrFail($id);
        $brands     = Brand::active()->orderBy('name')->get();
        $categories = Category::active()->orderBy('name')->get();
        $galleries  = [];

        foreach ($product->gallery ?? [] as $key => $gallery) {
            $img['id']   = $gallery;
            $img['src']  = getImage(getFilePath('productGallery') . '/' . $gallery);
            $galleries[] = $img;
        }

        return view('admin.product.edit', compact('pageTitle', 'product', 'brands', 'categories', 'galleries'));
    }

    public function status($id)
    {
        return Product::changeStatus($id);
    }
}
