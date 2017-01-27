<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'parent_id', 'slug', 'type'];
    
    
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'post_categories', 'category_id', 'post_id');
    }

    public function parent() 
    {
        return $this->hasOne('App\Category', 'id', 'parent_id');

    }

    public function children() 
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');

    }  

    public static function tree($parentId = 0, $type = 'post')
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))
            ->where('type', '=', $type)
            ->where('parent_id', '=', $parentId)->get();
    }
    
    
}
