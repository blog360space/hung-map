<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Exception;
use Parsedown;
use App\Helpers\Cms;

class FeIndexController extends Controller 
{
    public function getIndex()
    {        
        $search = isset($request->search) ? trim($request->search) : "";
        
        $query = Post::orderBy('posts.created_at', 'desc')
                ->where('type', '=', 'post')->whereIn('posts.status', [Cms::Active]);
        if ($search != "") {
            $query->where('posts.title', 'LIKE', '%' . addslashes($search) . '%');
        }
        
        return view('frontend.index.welcome', [
            'posts' => $query->simplePaginate(10),
        ]);
    }
    
    public function getAbout()
    {
        $slug = 'about';  
        
        $post = Post::where('slug', $slug)->first();
        
        return view('frontend.index.about', [
            'title' => 'Giới thiệu',
            'post' => $post
        ]);
    }
    
    public function getContact()
    {
        return view('frontend.index.contact', [
            'title' => 'Liên hệ'
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPost(Request $request, $id = 0, $slug = '')
    {        
        try {
            $post = Post::where('id', $id)->first();
            if (! $post) {
                throw new Exception('Page not found');
            }

            return view('frontend.index.post', [
                'title' => $post->title,
                'post' => $post
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}