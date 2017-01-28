<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'price'];
    
    public function categories()
    {
        return $this->belongsToMany(
                'App\Category',
                'product_categories',
                'product_id',
                'category_id', 'categories'
            );
    }
}
