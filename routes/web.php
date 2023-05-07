<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RazorpayController;

use App\Models\Menu;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('product', ProductController::class);
Route::get('product-listing',[ProductController::class,'productList'])->name('productList');

Route::post('razorpay/make-order',[RazorpayController::class,'makeOrder'])->name('razorpay.makorder');
Route::get('razorpay/success',[RazorpayController::class,'success'])->name('razorpay.success');
Route::get('test', function() {



  function test($strs) {
    
    if(count($strs) == 1){
      return implode('', $result);
    }
    $loopq = 0;
    $result = [];
    for ($i = 0; $i < count($strs); $i++) {
      if ($loopq == 0) {
        $result = str_split($strs[1]);
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
      echo var_dump($result) .'<br>';
    }
    return count($result) > 0 ? implode('', $result) : "";
  }
  //echo test(["flower", "flow", "flight"]);
  echo test(["reflower","flow","flight"]);
 // echo test(["cir","car"]);
});