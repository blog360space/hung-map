<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Repositories\CategoryRepository;
use App\PostCategory;
use DB;

class AdminCategoryController extends Controller
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
    public function index($type = 'post')
    {
        $tree = Category::tree(0, $type);     
        $tree = $this->categoriesRepo->displayCategory($tree);
        
        return view('admin.categories.index', ['tree' => $tree]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        
        return view('admin.categories.create', [
           
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
            'type' => $request->type,
        ]);
        
        $request->session()->flash('successMessage', 'Create new post successfully.');        
        
        return redirect('/admin/categories/create');
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
        return view('admin.categories.edit', [
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
        $category->type = $request->type;
        
        $category->save();        
        
        $request->session()->flash('successMessage', 'Update category successfully.');
        
        return redirect('/admin/categories/edit/' . $id);
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
                
                $tree = $category->tree($category->id, 'post');
                $ids = $this->categoriesRepo->getTreeIds($tree);
                
                PostCategory::whereIn('category_id', $ids)->update(['category_id' => 1]);
                DB::table('categories')->whereIn('id', $ids)->delete();
                
            break;
        }
        
        
        if (! $category) {
            throw new \Exception('Page not found');
        }
        
        $category->delete();
        
        $request->session()->flash('successMessage', 'Delete category successfully');
        
        return redirect('/admin/categories');
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
