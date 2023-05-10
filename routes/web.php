<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\FileImportController;

use App\Models\Product;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();


Route::get('upload-file-view',[FileImportController::class,'index'])->name('file-import-view');
Route::post('uploadFile',[FileImportController::class,'uploadFile'])->name('uploadFile');
Route::get('get-batch-by-id/{batchId}',[FileImportController::class,'getBatchById'])->name('getBatchById');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('product', ProductController::class);
Route::get('product-listing',[ProductController::class,'productList'])->name('productList');

Route::post('razorpay/make-order',[RazorpayController::class,'makeOrder'])->name('razorpay.makorder');
Route::get('razorpay/success',[RazorpayController::class,'success'])->name('razorpay.success');

Route::get('chart',function (){

$product = Product::selectRaw('
  count(*) as product_count,
  monthname(created_at) as product_month')
  ->whereYear('created_at',date('Y'))
  ->groupByRaw('month(created_at)')
  ->pluck('product_month','product_count');
 $months = $product->values();
 $product_count = $product->keys();
 
  return view('chart',['months' => $months,'product_count' => $product_count]);
});
Route::get('test1',function(){
  for ($i = 1; $i <= 5; $i++) {
     for ($b = 5; $b > $i; $b--) {
         echo '&nbsp';
     }
    
    for ($c = 0; $c < $i; $c++) {
       echo '*';
    }
     echo '<br>';
  }
  
  for ($p = 0; $p <= 5; $p++) {
    for ($j = 0; $j <= $p; $j++) {
        echo '&nbsp';
     }
     for ($k = 4; $k > $p; $k--) {
        echo '*';
     }
     
     
     echo '<br>';
  }
});

Route::get('test', function() {






function getstring($s){
  if(!$s){
    return 1;
  }
  $string_array = str_split($s);
  $main_arry = [];
  $temp_arry =[];
  foreach ($string_array as  $value) {
    if(!in_array($value,$temp_arry)){
      $temp_arry[] = $value;
    }else{
      $main_arry[] = $temp_arry;
      $temp_arry=[];
      $temp_arry[] = $value;
    }
  }
  $main_arry[] = $temp_arry; 
  dd($main_arry);
  return count(max($main_arry));
}

echo getstring('dvdf');
//echo longstring('bbbbb');
//echo longstring('pwwkew');
//echo longstring('aab');









function longstring($s){
    if($s == ""){
      return 0;
    }else if($s == " " || strlen($s) == 1){
      return 1;
    }
  $array_ste = str_split($s);
  
  if(count(array_unique($array_ste)) == count($array_ste)){
    return count($array_ste);
  }
  
  $attau = [];
  for ($i = 0; $i < count($array_ste); $i++) {
      $findIndez = strpos($s,$array_ste[$i],$i+1);
      $subStrLenth = $i;
      if(!$findIndez){
        $findIndez = $i+1;
        $subStrLenth = 0;
        //dd($s,$array_ste[$i],$i+1);
       // dd($s,$i,$findIndez-$i);
      }
      $substring = substr($s,$i,$findIndez-$subStrLenth);
      if($i == 1){
        //dd($s,$array_ste[$i],$i+1);
      }
      
      $attau[] = $substring;
  }
  

  max(array_map('strlen',$attau));
  return strlen(max($attau));
}
//echo longstring('abcabcbb');
//echo longstring('bbbbb');
//echo longstring('pwwkew');
//echo longstring('aab');









  function test($strs) {
    
    if($strs == ""){
      return 0;
    }
    $loopq = 0;
    $result = [];
    for ($i = 0; $i < count($strs); $i++) {
      if ($loopq == 0) {
        $result = str_split($strs[0]);
        $loopq = 1;
      }
      $curent_str = str_split($strs[$i]);
      $check = 0;
      $result = array_intersect_uassoc($curent_str, $result, function ($a, $b) use ($check){
        if ($a === $b) {
          return 0;
        }else {
          return false;
        }
        return ($a > $b)?1:-1;
      });
    }
    return count($result) > 0 ? implode('', $result) : "";
    
    
    
  }
  //echo test(["flower", "flow", "flight"]);
  //echo test(["reflower","flow","flight"]);
 //echo test(["cir","car"]);
});