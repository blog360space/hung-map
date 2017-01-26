<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    /**
     *
     * @var App\Repositories\CategoryRepository 
     */
    private $categoriesRepo;
    
    public function __construct(CategoryRepository $categoriesRepo) {
        $this->middleware('auth');
        
        $this->categoriesRepo = $categoriesRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree = Category::tree();     
        $tree = $this->categoriesRepo->displayCategory($tree);
        
        return view('categories.index', ['tree' => $tree]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        
        return view('categories.create', [
           
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
        $this->validForm($request);
        
        $category = Category::create([
            'title' => $request->title,
            'slug' => $request->slug,        
        ]);
        
        $request->session()->flash('successMessage', 'Create new post successfully.');        
        
        return redirect('/categories/create');
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
    public function getEdit($id)
    {
        $category = Category::where('id', $id)->first();        
        return view('categories.edit', [
           'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $id)
    {
        $this->validForm($request);
        
        $category = Category::where('id', $id)->first();
        
        if (! $category) {
            throw new Exception('Page not found');
        }
        
        $category->title = $request->title;
        $category->parent_id = $request->parent_id;
        $category->slug = $request->slug;
        
        $category->save();        
        
        $request->session()->flash('successMessage', 'Update category successfully.');
        
        return redirect('/categories/edit/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDestroy(Request $request, $id)
    {   
        $category = Category::where('id', $id)->first();
        
        if (! $category) {
            throw new Exception('Page not found');
        }
        
        switch ($category->type) {
            case 'post' :
                $this->categoriesRepo->setPostsToUncategorized($category);
            break;
        }
        
        
        if (! $category) {
            throw new \Exception('Page not found');
        }
        
        $category->delete();
        
        $request->session()->flash('successMessage', 'Delete category successfully');
        
        return redirect('/categories');
    }
    
    private function validForm(Request $request) 
    {        
        $this->validate($request, [
            'title' => 'required|max:100'
        ]);
        
        $this->validate($request, [
            'slug' => 'required|max:100'
        ]);
        
    }
}