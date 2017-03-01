<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Exception;
use App\Helpers\Cms;
use App\Repositories\CategoryRepository;
use App\Category;

class FeIndexController extends Controller 
{
    public function __construct(CategoryRepository $categoriesRepo) 
    {        
        $this->categoriesRepo = $categoriesRepo;
    }
    
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
            'tree' => $this->getCategoryTree()
        ]);
    }
    
    public function getCategory($slug, $categoryId)
    {   
        $search = isset($request->search) ? trim($request->search) : "";
        
        $query = Post::orderBy('posts.created_at', 'desc')
                ->where('type', '=', 'post')->whereIn('posts.status', [Cms::Active]);
        
        if ($search != "") {
            $query->where('posts.title', 'LIKE', '%' . addslashes($search) . '%');
        }
        
        if (trim($categoryId) != "") {
            $query->join('post_categories', 'post_categories.post_id', '=', 'posts.id')
                ->where('post_categories.category_id', '=', $categoryId );
        }
        
        return view('frontend.index.welcome', [
            'posts' => $query->simplePaginate(10),
            'tree' => $this->getCategoryTree()
        ]);
    }
    
    public function getTag($slug = '')
    {           
        $search = isset($request->search) ? trim($request->search) : "";
        
        $query = Post::orderBy('posts.created_at', 'desc')
                ->where('type', '=', 'post')->whereIn('posts.status', [Cms::Active]);
        
        if ($search != "") {
            $query->where('posts.title', 'LIKE', '%' . addslashes($search) . '%');
        }
        
        if (trim($slug) != "") {           
            $query->join('post_tags', 
                    'post_tags.post_id', '=', 'posts.id')
                  ->join('tags', 
                    'post_tags.tag_id','=', 'tags.id')
                ->where('tags.slug', '=', $slug );
        }
        
        return view('frontend.index.welcome', [
            'posts' => $query->simplePaginate(10),
            'tree' => $this->getCategoryTree()
        ]);
    }
    
    public function getAbout()
    {
        $slug = 'about';  
        
        $post = Post::where('slug', $slug)->first();
        
        return view('frontend.index.about', [
            'title' => 'Giới thiệu',
            'post' => $post,
            'tree' => $this->getCategoryTree()
        ]);
    }
    
    public function getContact()
    {
        return view('frontend.index.contact', [
            'title' => 'Liên hệ',
            'tree' => $this->getCategoryTree()
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPost(Request $request, $slug = '', $id = 0)
    {        
        try {
            $post = Post::where('id', $id)->first();
            if (! $post) {
                throw new Exception('Page not found');
            }
            $preview = false;
            
            if ($post->status == Cms::Draft && $request->preview == '1') {
                 $loginUser = $request->user();
                 if (! isset($loginUser->id) ) {
                     throw new Exception('Page not found');
                 } else {
                     $preview = true;
                 }
            }

            return view('frontend.index.post', [
                'title' => $post->title,
                'post' => $post,
                'preview' => $preview,
                'tree' => $this->getCategoryTree()
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    private function getCategoryTree()
    {
        $tree = Category::tree(0, 'post');     
        $tree = $this->categoriesRepo->displayCategory(
                $tree, false, [], '/category/');
        
        return $tree;
    }
}