<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function scopeStockCheck($query){
        return $query->where('quantity', '>', 0);
    }

    public function quantityBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->quantity == 0) {
                    return '<span class="badge badge--danger">' . trans('Out of Stock') . '</span>';
                } elseif ($this->quantity < 10) {
                    return '<span class="badge badge--warning">' . $this->quantity . '</span>';
                } else {
                    return '<span class="badge badge--primary">' . $this->quantity . '</span>';
                }
            }
        );
    }
}
