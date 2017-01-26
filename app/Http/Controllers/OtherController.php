<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Tag;

class OtherController extends Controller
{
    public function tags()
    {
        try {            
            $tags = [];
            $items = Tag::select('title')->get();
            
            foreach ($items as $tag) {
                $tags[] = $tag->title;
            }
            
            return response()->json([
                'data' => $tags
            ]);
        } catch (\Exception $ex) {
            return response()->json(['msg' => $ex->getMessage()], 400);
        }
        
    }
}
