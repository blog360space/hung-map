<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use Exception;
use App\Repositories\CategoryRepository;
use App\Category;
use App\Branch;
use App\Vehicle;

class AdminProductController extends Controller
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
    public function index(Request $request)
    {
        $categoryId = isset($request->category) ? $request->category : "";
        $branchId = isset($request->branch) ? $request->branch : "";
        $vehicleId = isset($request->vehicle) ? $request->vehicle : "";
        $search = isset($request->search) ? trim($request->search) : "";
        
        $tree = $this->categoryMd->tree(0,'product');    
        $branches = Branch::getArrayForDropDownList();
        $vehicles = Vehicle::getArrayForDropDownList();
        
        $str = $this->categoryRepo->getOptionSelect($tree, "", [
            'selected_id' => $categoryId
        ]);
        
        $query = Product::orderBy('products.title');
        
        if (trim($categoryId) != "") {
            $query->join('product_categories', 
                    'product_categories.product_id', '=', 'products.id')
                ->where('product_categories.category_id', '=', $categoryId );
        }
        
        if (trim($branchId) != "") {
            $query->join('product_branches', 
                    'product_branches.product_id', '=', 'products.id')
                ->where('product_branches.branch_id', '=', $branchId );
        }
        
        if (trim($vehicleId) != "") {
            $query->join('product_vehicles', 
                    'product_vehicles.product_id', '=', 'products.id')
                ->where('product_vehicles.vehicle_id', '=', $vehicleId );
        }
        
        if ($search != "") {
            $query->where('products.title', 'LIKE', '%' . addslashes($search) . '%');
        }
        
        return view('admin.products.index', [
            'products' => $query->simplePaginate(15),
            'categoryFilter' => $str,
            'branches' => $branches,
            'vehicles' => $vehicles
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
        
        return view('admin.products.create', [
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
        
        if (isset($request->tag) ) {
            $product->setTags($request->tag);
        }
        
        if (isset($request->branch)) {
            $product->setBranches($request->branch);
        }
        
        if (isset($request->vehicle)) {
            $product->setVehicles($request->vehicle);
        }
        
        $request->session()->flash('successMessage', 'Create new product successfully.');
        
        return redirect('/adminproducts/create');
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
        
        $ids = $product->categories()->getRelatedIds()->toArray();
        $tree = $this->categoryMd->tree(0, 'product');        
        $tree = $this->categoryRepo->displayCategory($tree, true, $ids);
        
        $product->tag = $product->getStrTags();
        $product->branch = $product->getStrBranches();
        $product->vehicle = $product->getStrVehicles();
        
        
        return view('admin.products.edit', [
            'product' => $product,
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
        
        if (isset ($request->categories)) {
            $product->categories()->sync($request->categories);
        }
        
        if (isset($request->tag) ) {
            $product->setTags($request->tag);
        }
        
        if (isset($request->branch)) {
            $product->setBranches($request->branch);
        }
        
        if (isset($request->vehicle)) {
            $product->setVehicles($request->vehicle);
        }
        
        $request->session()->flash('successMessage', 'Update product successfully.');        
        return redirect('/adminproducts/edit/' . $product->id . '/' . $product->title);
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
