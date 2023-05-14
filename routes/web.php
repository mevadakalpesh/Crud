<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\FileImportController;
use App\Http\Controllers\SocialiteAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use App\Models\Product;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

Route::get('assign-role', function () {
  $user = App\Models\User::find(2);
  $user->assignRole([1]);
  dd('done');
});

Route::get('upload-file-view', [FileImportController::class, 'index'])->name('file-import-view');
Route::post('uploadFile', [FileImportController::class, 'uploadFile'])->name('uploadFile');
Route::get('get-batch-by-id/{batchId}', [FileImportController::class, 'getBatchById'])->name('getBatchById');


//OAuth Routes
Route::get('auth/{provider}/redirect', [SocialiteAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('auth/{provider}/callback', [SocialiteAuthController::class, 'callback'])->name('oauth.callback');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'],function(){
Route::resource('product', ProductController::class);
Route::get('product-listing', [ProductController::class, 'productList'])->name('productList');
});

//Role Routes
Route::resource('role', RoleController::class);

//User Routes
Route::resource('user', UserController::class);


Route::post('razorpay/make-order', [RazorpayController::class, 'makeOrder'])->name('razorpay.makorder');
Route::get('razorpay/success', [RazorpayController::class, 'success'])->name('razorpay.success');

Route::get('chart', function () {

  $product = Product::selectRaw('
  count(*) as product_count,
  monthname(created_at) as product_month')
  ->whereYear('created_at', date('Y'))
  ->groupByRaw('month(created_at)')
  ->pluck('product_month', 'product_count');
  $months = $product->values();
  $product_count = $product->keys();

  return view('chart', ['months' => $months, 'product_count' => $product_count]);
});
Route::get('test1', function() {
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


  function testdata($num1, $num2) {
    $main_array = [];
    $status = true;
    $sum2bkp = $num2;
    sort($num2);
    sort($num1);
    for ($i = 0; $i < count($num1); $i++) {
      $main_array[] = $num1[$i];

      $sumnext = isset($num1[$i+1]) ? $num1[$i+1] : $num1[count($num1) - 1];
      if ($num1[$i]+1 != $sumnext && $status) {
        
        $search_key = array_search($num1[$i]+1, $num2);
        if ($search_key !== false) {
          $main_array[] = $num2[$search_key];
        }
        if ((count($num1) - 1) == $i) {
            $main_array = array_merge($main_array, $num2);
        } 
        unset($num2[$search_key]);
      }
    }
    if (count($main_array) == 0) {
      $main_array = $sum2bkp;
    }
    sort($main_array);
  

    $first_val = $main_array[(count($main_array) / 2)] ?? 0;
    $secod_val = $main_array[(count($main_array) / 2) - 1] ?? 0;
    $first_val = is_array($first_val) ? $first_val[0] : $first_val;
    $secod_val = is_array($secod_val) ? $secod_val[0] : $secod_val;
    if (count($main_array) % 2 == 0) {
      return number_format(($first_val+$secod_val) / 2, 5, ".");
    } else {
      return number_format($first_val, 5, ".");
    }
  }
  
  
  function testdata1($num1,$num2){
    $num1sum = array_sum($num1);
    $num2sum = array_sum($num2);
     $data = ($num1sum + $num2sum) / count(array_merge($num1,$num2));
     return number_format($data,5);
  }
  //echo testdata([1, 3], [2]); //2.00000
  //echo testdata([1, 2], [3, 4]); //2.50000
  //echo testdata([3],[-2,-1]);  //-1.00000
  //echo testdata([2,2,4,4],[2,2,4,4]);  //3.00000
  //echo testdata([1,2],[3,4]);  //3.00000
  //echo testdata([2,2,4,4][2,2,4,4]);  //3.00000
  echo testdata([1,3],[2,7]);  //3.00000


});