<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'sku', 'brand', 'description', 'price', 'sale_price', 'image', 'stock', 'category_id', 'weight', 'dimensions', 'tags', 'is_featured', 'is_hot_offer', 'is_new_arrival'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
