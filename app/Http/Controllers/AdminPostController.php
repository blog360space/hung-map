<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Category;
use App\Helpers\Cms;
use Exception;
use Auth;

class AdminPostController extends Controller
{
    /**
     * App\Repositories\PostRepository
     */
    private $postRepo;
    
    /**
     * @var App\Category
     */
    private $categoryMd;
    
    /**    
     * @var App\Repositories\CategoryRepository
     */
    private $categoryRepo;   
    
    private $postType = 'post';


    public function __construct(CategoryRepository $categoryRepo, 
            PostRepository $postRepo, 
            Category $categoryMd) 
    {
        $this->middleware('auth');
        
        $this->categoryRepo = $categoryRepo;
        $this->categoryMd = $categoryMd;
        $this->postRepo = $postRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categoryId = isset($request->category) ? $request->category : "";
        $status = isset($request->status) ? $request->status : "";
        $search = isset($request->search) ? trim($request->search) : "";
        
        $tree = $this->categoryMd->tree(0,'post');    
      
        $str = $this->categoryRepo->getOptionSelect($tree, "", [
            'selected_id' => $categoryId
        ]);
        
        $query = Post::orderBy('posts.created_at', 'desc')
                ->orderBy('posts.status', 'desc')
                ->where('type', '=', 'post');
        
        if (trim($categoryId) != "") {
            $query->join('post_categories', 'post_categories.post_id', '=', 'posts.id')
                ->where('post_categories.category_id', '=', $categoryId );
        }
        
        if (trim($status) != "") {
            $query->where('posts.status', '=', $status);
        } else {
            $query->whereIn('posts.status', [Cms::Active, Cms::Draft]);
        }
        
        if ($search != "") {
            $query->where('posts.title', 'LIKE', '%' . addslashes($search) . '%');
        }
       
        return view('admin.posts.index', [
            'posts' => $query->simplePaginate(15),
            'categoryFilter' => $str
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $tree = $this->categoryMd->tree();        
        $tree = $this->categoryRepo->displayCategory($tree, true);
        
        return view('admin.posts.create', [
            'post' => new Post(),
            'tree' => $tree
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
        $user = Auth::user();
        $this->validateForm($request);
        $data = [
            'title' => isset($request->title) ? $request->title : '',
            'slug' => isset($request->slug) ? Post::checkSlug($request->slug) : '',
            'content' => isset($request->content) ? $request->content : '',
            'status' => isset($request->status) ? $request->status : Cms::Draft,
            'type' => $this->postType,
            'created_id' => $user->id
        ];
        $post = Post::create($data);
        $a = $post->toArray();
        if (isset ($request->categories)) {
            $post->categories()->sync($request->categories);
        }
        if (isset($request->tag) ) {
            $post->setTags($request->tag);
        }
        
        $request->session()->flash('successMessage', 'Create new post successfully.');        
        if ($request->continueEdit) {
            return redirect('/admin/posts/edit/' . $post->id . '/' . $post->slug);
        }
        return redirect('/admin/posts/create');
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
        $post = Post::where('id', $id)->first();  
        
        if (! $post) {
            throw new Exception("Post id $id not found");
        }
        
        $post->strTags = $post->getStrTags();
        
        $ids = $post->categories()->getRelatedIds()->toArray();        
        $tree = $this->categoryMd->tree();     
        $tree = $this->categoryRepo->displayCategory($tree, true, $ids);
        
        return view('admin.posts.form', [
            'post' => $post,
            'tree' => $tree
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
        $user = Auth::user();
        $post = Post::where('id', $id)->first();
        
        if (! $post) {
            throw new Exception('Page not found');
        }        
        $this->validateForm($request);
            
        $post->title = $request->title;
        $post->slug = Post::checkSlug($request->slug);
        $post->content = $request->content;        
        $post->status = isset($request->status) ? $request->status : Cms::Draft;     
        $post->type = $this->postType;
        $post->updated_id = $user->id;
        
        if (! $post->save()) {
            throw new Exception('Db error');
        }       
        
        if (isset ($request->categories)) {
            $post->categories()->sync($request->categories);
        }
        if (isset($request->tag) ) {
            $post->setTags($request->tag);
        }
        
        $request->session()->flash('successMessage', 'Update post successfully.');
        
        return redirect('/admin/posts/edit/' . $post->id . '/' . $post->slug);
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
