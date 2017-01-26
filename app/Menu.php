<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'uri'];

    public function parent() 
    {
        return $this->hasOne('App\Menu', 'id', 'parent_id');

    }

    public function children() 
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id')->orderBy('num', 'asc');

    }  

    public static function tree($parentId = 0, $type = 'frontend') 
    {        
        return static::with(implode('.', array_fill(0, 100, 'children')))
                ->where('parent_id', '=', $parentId)
                ->where('type', '=', $type)
                ->get();

    }
}
