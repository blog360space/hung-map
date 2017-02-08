<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public static function getArrayForDropDownList($addFistItem = true)
    {
        $arr = self::orderBy('title', 'asc')->get();
        $vehicles = [];
        
        if ($addFistItem) {
            $vehicles[''] = 'Vehicles';
        }
        
        foreach ($arr as $item) {
            if (trim($item->title) != '') {
                $vehicles[$item->id] = $item->title;
            }
        }
        
        return $vehicles;
    }
}
