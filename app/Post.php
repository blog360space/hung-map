<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'status'];
    
    public function categories()
    {   
        return $this->belongsToMany('App\Category', 
            'post_categories', 
            'post_id', 
            'category_id' ,  'categories');
    }
    
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 
            'post_tags', 
            'post_id', 
            'tag_id' ,  'tags');
    }
    
    public static function checkSlug($slug) {
        $tmp = explode("-", $slug);        
        $count = Post::where('slug', '=', $slug )->count();        
        if ($count > 1) {
            $slug .= "-" . $count +1;
        }
        
        return $slug;
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
        
        $this->tags()->sync($tagsId);
    }

    public function getStrTags()
    {
        $strTags = '';
        $tags = $this->tags();
        
        foreach ($this->tags as $k => $tag) {

            if ($k == 0) {
                $strTags .= "";
            } else {
                $strTags .= ",";
            }

            $strTags .= $tag->title;
        }
           
        return $strTags;
    }
}
