<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'uri'];

    public function parent() 
    {
        return $this->hasOne('App\Menu', 'id', 'parent_id');

    }

    public function children() 
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id');

    }  

    public static function tree($type = 'frontend') 
    {
        return static::with(implode('.', array_fill(0, 100, 'children')))
                ->where('parent_id', '=', 0)
                ->where('type', '=', $type)
                ->get();

    }
}
