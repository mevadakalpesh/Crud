<?php
namespace App\Services;
use App\Models\Product;
class ProductService {
  public $product;
  public function __construct(Product $product){
    $this->product = $product;
  }
  
  public function getProducts($selectRaw= false, $where = [],$exceptCol =[]){
    return $this->product->exceptCol($exceptCol)->when($selectRaw,function($q) use ($selectRaw){
       $q->selectRaw($selectRaw);
    })->where($where)->orderBy('created_at','desc')->get();
  }
  
  public function createProduct($data){
    return $this->product->create($data);
  }
  
  public function deleteProduct($id){
    return $this->product->findOrFail($id)->delete();
  }
  
  public function getProduct($id){
    return $this->product->findOrFail($id);
  }
  
  public function updateProduct($where=[],$data = []){
    return $this->product->where($where)->update($data);
  }
  
}