<?php

namespace App\Repositories;

use App\PostCategory;
use App\Category;

class CategoryRepository 
{
    /**     
     * @param type $tree
     * @return string html
     */
    public function displayCategory($tree = [],  
            $checkbox = false, $relatedIds = [], 
            $url = '/categories/edit', $slug = false)
    {
        $str = '<ul class="categories">';
        foreach ($tree as $category) {
            $strCkb = "";
            
            if ($checkbox) {
                $checked = "";
                                
                if (in_array($category->id, $relatedIds)) {
                    $checked = 'checked="checked"';
                }
                $strCkb = '<input name="categories[]" ' 
                        . 'id="num-' . $category->id . '"'
                        
                        . $checked 
                        . ' type="checkbox" value="' 
                        . $category->id . '" /> '  ;
                
                $str .= "<li>"  
                    . $strCkb
                    . '<label for="num-' . $category->id.'">'
                    . $category->title . "</label></li>";
            }
            else {
                $str .= "<li>"  
                    . '<a href="' . url($url) . '/' . $category->id . '">'
                    . $category->title . "</a></li>";
            }
            
            
            if (count($category->children)) {
                $str .= $this->displayCategory($category->children, 
                        $checkbox, $relatedIds, $url, $slug );
            }
        }
        
        $str .="</ul>";
        
        return $str;
    }
    
    /**
     * 
     * @param type $categoryId
     */
    public function setPostsToUncategorized(Category $category) 
    {
        $children = $category->children();
        
        
        $itemsId = [];
        foreach ($children as $category) {
            var_dump($category);
            $itemsId[] = $category->id;
        }
        
       
        PostCategory::where('category_id', '=', $category->id)->update(['category_id' => 1]);
    }
    
    public function getOptionSelect($tree = [], $lv = "", $params = [])
    {
        $selectedId = isset($params['selected_id']) ? $params['selected_id'] : -1;
        $str = '';
        $selected = "";
        foreach ($tree as $item) {
            
            $selected = "";
            if ($item->id == $selectedId) {
                $selected = 'selected="selected"';
            }
            
            $str .= '<option value="'. $item->id .'" ' . $selected . ' >';
            $str .= $lv . $item->title;
            $str .= "</option>";
            if (count($item->children)) {
                
                $str .= $this->getOptionSelect($item->children, $lv . "--", $params);
            }
        }
        
        $str .= "";
        return $str;
    }
}
