<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use GlobalStatus;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->where('quantity', '!=', 0);
    }
}
