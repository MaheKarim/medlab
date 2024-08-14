<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use GlobalStatus;

    protected $casts = [
        'gallery'  => 'array'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeAvailable($query)
    {
        return $query->active()->whereHas('category', function ($category) {
            $category->active();
        })->whereHas('brand', function ($brand) {
            $brand->active();
        });
    }
}
