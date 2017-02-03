<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public static function getArrayForDropDownList($addFistItem = true)
    {
        $arr = self::orderBy('title', 'asc')->get();
        $branches = [];
        
        if ($addFistItem) {
            $branches[''] = '-- Branches --';
        }
        
        foreach ($arr as $item) {
            if (trim($item->title) != '') {
                $branches[$item->id] = $item->title;
            }
        }
        
        return $branches;
    }
}
