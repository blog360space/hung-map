<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Helpers\Cms;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $status = isset($request->status) ? $request->status : "";
        $query = Post::orderBy('posts.created_at', 'desc')->where('type', '=', 'page');
        
        if (trim($status) != "") {
            $query->where('posts.status', '=', $status);
        } else {
            $query->whereIn('posts.status', [Cms::Active, Cms::Draft]);
        }
        
        return view('admin.pages.index', [
            'posts' => $query->simplePaginate(15),            
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {        
        return view('admin.pages.create', [
            'post' => new Post()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {        
        $this->validateForm($request);
        
        $post = Post::create([
            'title' => isset($request->title) ? $request->title : '',
            'slug' => isset($request->slug) ? Post::checkSlug($request->slug) : '',
            'content' => isset($request->content) ? $request->content : '',
            'status' => isset($request->status) ? $request->status : Cms::Draft,
            'type' => 'page'
        ]);
        
        $request->session()->flash('successMessage', 'Create new page successfully.');        
        
        return redirect('/admin/pages/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id, $slug = '')
    {
        $post = Post::where('id', $id)->where('type', '=', 'page')->first();                 
                
        return view('admin.pages.form', [
            'post' => $post,           
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $id, $slug = '')
    {   
        $post = Post::where('id', $id)->where('type', '=', 'page')->first();
        
        if (! $post) {
            throw new Exception('Page not found');
        }        
        $this->validateForm($request);
            
        $post->title = $request->title;
        $post->slug = Post::checkSlug($request->slug);
        $post->content = $request->content;        
        $post->status = isset($request->status) ? $request->status : Cms::Draft;     
        
        if (! $post->save()) {
            throw new Exception('Db error');
        }       
        
        $request->session()->flash('successMessage', 'Update post successfully.');
        
        return redirect('/admin/pages/edit/' . $post->id . '/' . $post->slug);
    }
    
    /**
     * Validate form input
     * @param \Illuminate\Http\Request $request
     */
    private function validateForm(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:150'
        ]);
        
        $this->validate($request, [
            'slug' => 'required|max:150'
        ]);
        
        $this->validate($request, [
            'content' => 'required'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = 0)
    {        
        $post = Post::where('id', $id)->first();
        if (! $post) {
            throw new \Exception('Page not found');
        }
        
        if ($post->status == Cms::Trash) {
            $post->delete();
        }
        else {
            $post->trash();
        }
        
        $request->session()->flash('successMessage', 'Delete post successfully');
        
        return redirect('/admin/posts');
    }
}
