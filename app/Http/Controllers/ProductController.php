<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use Exception;
use App\Repositories\CategoryRepository;
use App\Category;

class ProductController extends Controller
{    
    
    /**
     * @var App\Category
     */
    private $categoryMd;
    
    /**    
     * @var App\Repositories\CategoryRepository
     */
    private $categoryRepo;   
    
    public function __construct(CategoryRepository $categoryRepo, Category $categoryMd) 
    {
        $this->middleware('auth');
        
        $this->categoryRepo = $categoryRepo;
        $this->categoryMd = $categoryMd;        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Product::orderBy('products.title');
        
        return view('products.index', [
            'products' => $query->simplePaginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $tree = $this->categoryMd->tree(0, 'product');        
        $tree = $this->categoryRepo->displayCategory($tree, true);
        
        return view('products.create', [
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
        $this->validateForm($request);
        
        $data = [
            'title' => isset($request->title) ? $request->title : '',
            'price' => isset($request->price) ? $request->price : 0,
            'description' => isset($request->description) ? $request->description : 0,
        ];
        $product = Product::create($data);
        
        if (isset ($request->categories)) {
            $product->categories()->sync($request->categories);
        }
        
        $request->session()->flash('successMessage', 'Create new product successfully.');
        
        return redirect('products/create');
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
    public function getEdit(Request $request, $id = 0, $slug)
    {
        $product = Product::where('id', $id)->first();
        
        if (!$product) {
            throw new Exception("Product id $id not found");
        }
        
        return view('products.edit', [
            'product' => $product
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
        $product = Product::where('id', '=', $id)->first();
        
        if (! $product) {
            throw new Exception('Product id ' . $id . 'not found');
        }
        
        $this->validateForm($request);        
        
        $product->title = isset($request->title) ? $request->title : '';
        $product->price = isset($request->price) ? $request->price : 0;
        $product->description = isset($request->description) ? $request->description : '';
        $product->save();
        
        $request->session()->flash('successMessage', 'Update product successfully.');        
        return redirect('products/edit/' . $product->id . '/' . $product->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Validate form input
     * @param \Illuminate\Http\Request $request
     */
    private function validateForm(Request $request)
    {
        $this->validate($request, [
            'title' => 'required | max:150'
        ]);
       
        
        $this->validate($request, [
            'price' => 'required | numeric'
        ]);
    }
}
