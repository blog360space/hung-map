<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Tag;
use App\Branch;
use App\Vehicle;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    /**
     * Get tags
     * @return string json
     */
    public function getTags()
    {
        try {            
            $tags = [];
            $items = Tag::orderBy('title', 'asc')->select('title')->get();
            
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
    
    public function getBranches()
    {
        try {            
            $branches = [];
            $items = Branch::orderBy('title', 'asc')->select('title')->get();
            
            foreach ($items as $branch) {
                $branches[] = $branch->title;
            }
            
            return response()->json([
                'data' => $branches
            ]);
            
        } catch (\Exception $ex) {
            return response()->json(['msg' => $ex->getMessage()], 400);
        }
    }
    
    public function getVehicles()
    {
        try {            
            $vehicles = [];
            $items = Vehicle::orderBy('title', 'asc')->select('title')->get();
            
            foreach ($items as $vehicle) {
                $vehicles[] = $vehicle->title;
            }
            
            return response()->json([
                'data' => $vehicles
            ]);
            
        } catch (\Exception $ex) {
            return response()->json(['msg' => $ex->getMessage()], 400);
        }
    }    
}
