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
    
    public function branches()
    {
        return $this->belongsToMany(
                'App\Branch', 
                'product_branches', 
                'product_id', 
                'branch_id', 
                'branches');
    }
    
    public function vehicles()
    {
        return $this->belongsToMany(
                'App\Vehicle', 
                'product_vehicles', 
                'product_id', 
                'vehicle_id', 
                'vehicles');
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
    
    public function setBranches($strBranches) 
    {        
        $branches = explode(',', $strBranches);
        $ids = [];
        
        foreach ($branches as $title) {
            
            $title = trim(str_replace(['"', "'", "\\", "/" ], "", $title));            
            $branch = Branch::where('title', $title)->first(['id', 'title']);
            
            if (! $branch) {
                //create Tag
                $branch = new Branch();
                $branch->title = $title;            
                $branch->save();
            }
            
            $ids[] = $branch->id;
        }        
        $this->branches()->sync($ids);
    }
    
    public function setVehicles($strVehicles) 
    {        
        $vehicles = explode(',', $strVehicles);
        $ids = [];
        
        foreach ($vehicles as $title) {
            
            $title = trim(str_replace(['"', "'", "\\", "/" ], "", $title));            
            $vehicle = Vehicle::where('title', $title)->first(['id', 'title']);
            
            if (! $vehicle) {
                //create Tag
                $vehicle = new Vehicle();
                $vehicle->title = $title;            
                $vehicle->save();
            }
            
            $ids[] = $vehicle->id;
        }        
        $this->vehicles()->sync($ids);
    }
    
    /**
     * Get tags related to product
     * split by comma
     * @return str tags
     */
    public function getStrTags()
    {
        $strTags = '';
        
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
     * Get branches related to product
     * Split by a comma
     * @return str branches 
     */
    public function getStrBranches()
    {
        $strBranches = '';        
        
        foreach ($this->branches as $k => $branch) {

            if ($k == 0) {
                $strBranches .= "";
            } else {
                $strBranches .= ",";
            }

            $strBranches .= $branch->title;
        }
           
        return $strBranches;
    }
    
    /**
     * Get vehicle related to product
     * Split by a comma
     * @return str branches 
     */
    public function getStrVehicles()
    {
        $strVehicles = '';
        
        foreach ($this->vehicles as $k => $vehicle) {

            if ($k == 0) {
                $strVehicles .= "";
            } else {
                $strVehicles .= ",";
            }

            $strVehicles .= $vehicle->title;
        }
           
        return $strVehicles;
    }
}
