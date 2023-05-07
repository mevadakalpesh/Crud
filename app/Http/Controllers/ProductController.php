<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Product;
use DataTables;
use App\Http\Requests\ProductAddRequest;
use App\Http\Requests\ProductUpdateRequest;

use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
  public $productService;
  public function __construct(ProductService $productServicee) {
    $this->productService = $productServicee;
  }
  /**
  * Display a listing of the resource.
  */
  public function index(Request $request) {
    if ($request->ajax()) {
      $exceptCol = ['deleted_at','updated_at'];
      $pendingStatus = Product::$pendingStatus;
      $completedStatus = Product::$completedStatus;
      $selectRaw = "products.*,
                       case
                            when status = '$pendingStatus' then 'Pending'
                            else 'Completed'
                        end as status";

      $data = $this->productService->getProducts(selectRaw : $selectRaw, exceptCol : $exceptCol);
      return Datatables::of($data)
      ->addIndexColumn()
      ->addColumn('action', function(Product $product) {
        $btn = '<a href="javascript:void(0)" data-product_id="'.$product->id.'"  class="btn btn-primary product-edit btn-sm">Edit</a>
                <a href="javascript:void(0)" data-product_id="'.$product->id.'" class="btn btn-danger product-delete btn-sm ">Delete</a>';
        return $btn;
      })
      ->editColumn('image', function($product) {
        $image = '<img src="'.$product->image.'" class="listing-image">';
        return $image;
      })
      ->rawColumns(['image', 'action'])
      ->make(true);
    }
    return view('products.product-listing');
  }

  /**
  * Show the form for creating a new resource.
  */
  public function create() {}

  /**
  * Store a newly created resource in storage.
  */
  public function store(ProductAddRequest $request) {
  
    $data = [
      'name' => $request->name,
      'amount' => $request->amount,
      'image' => storeFile(Product::$filePath, $request->image, 'product'),
      'status' => $request->status,
      'description' => $request->description ?? null,
    ];
    $this->productService->createProduct($data);
    return response()->json(['status' => 200, 'message' => 'Product Add Successfully']);
  }

  /**
  * Display the specified resource.
  */
  public function show(string $id) {
  }

  /**
  * Show the form for editing the specified resource.
  */
  public function edit(string $id) {
    $result = $this->productService->getProduct($id);
    if ($result) {
      return response()->json(['status' => 200, 'message' => 'Product Get Successfully', 'result' => $result]);
    } else {
      return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
    }
  }

  /**
  * Update the specified resource in storage.
  */
  public function update(ProductUpdateRequest $request, string $id) {
    $data = [
      'name' => $request->name,
      'amount' => $request->amount,
      'status' => $request->status,
      'description' => $request->description ?? null,
    ];
    if ($request->has('image') && !blank($request->image)) {
      $data['image'] = storeFile(Product::$filePath, $request->image, 'product');
    }
    $this->productService->updateProduct([
      ['id', $id]
    ], $data);
    return response()->json(['status' => 200, 'message' => 'Product Edit Successfully']);
  }

  /**
  * Remove the specified resource from storage.
  */
  public function destroy(string $id) {
    $result = $this->productService->deleteProduct($id);
    if ($result) {
      return response()->json(['status' => 200, 'message' => 'Product Delete Successfully']);
    } else {
      return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
    }
  }
  
   public function productList(){
     $products = Product::all();
     return  view('product-show',['products' => $products]);
   }
  
}