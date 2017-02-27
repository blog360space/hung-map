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
    public function displayCategory(
            $tree = [],  
            $checkbox = false, 
            $relatedIds = [], 
            $url = '/categories/edit', 
            $slug = false)
    {
        $str = '<ul class="categories list-group">';
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
                
                $str .= "<li>  class=''"  
                    . $strCkb
                    . '<label for="num-' . $category->id.'">'
                    . $category->title . "</label></li>";
            }
            else {
                $str .= "<li class=''>"  
                    . '<a href="' . url($url) . '/' . $category->slug. '.' . $category->id . '">'
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
    
    public function getTreeIds($tree) 
    {
        $rs = [];
        foreach ($tree as $category) {
            $rs[] = $category->id;
            
            if (count($category->children)) {
                $tmp = $this->getTreeIds($category->children);
                
                $rs = array_merge($tmp, $rs);
            }
        }
        
        return $rs;
    }
}
