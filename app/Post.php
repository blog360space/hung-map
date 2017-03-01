<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Cms;

class Post extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'content', 
        'status', 
        'type',
        'created_id',
        'updated_id'
    ];
    
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
    
    public function user()
    {
        if (! $this->created_id) {
            return '';
        }
        
        $user = User::where('id', '=', $this->created_id)->first();
        
        if (! $user) {
            $user = User::where('id', '=', $this->updated_id)->first();
        }
        
        return $user;
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
            $tagslug = Cms::createSlug($tagName);
            $tag = Tag::where('slug', $tagslug)->first(['id', 'slug']);
            
            if (! $tag) {
                //create Tag
                $tag = new Tag();
                $tag->title = $tagName;
                $tag->slug = $tagslug;
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
    
    /**
     * update status to trash
     */
    public function trash()
    {
        $this->status = Cms::Trash;
        $this->save();
    }
}
