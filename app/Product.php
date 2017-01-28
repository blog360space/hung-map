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
    
    public function tags()
    {
        return $this->belongsToMany(
            'App\Tag', 
            'product_tags', 
            'product_id', 
            'tag_id' ,  'tags');
    }
    
    public function setTags($strTags) 
    {        
        $tagNames = explode(',', $strTags);
        $tagsId = [];
        
        foreach ($tagNames as $tagName) {
            
            $tagName = trim(str_replace(['"', "'", "\\", "/" ], "", $tagName));            
            $tag = Tag::where('title', $tagName)->first(['id', 'title']);
            
            if (! $tag) {
                //create Tag
                $tag = new Tag();
                $tag->title = $tagName;            
                $tag->save();
            }
            
            $tagsId[] = $tag->id;
        }
        var_dump($tagsId);
        $this->tags()->sync($tagsId);
    }
}
