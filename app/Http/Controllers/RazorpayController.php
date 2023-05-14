<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Product;
class RazorpayController extends Controller
{
  public $api;
  public function __construct() {
    $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  }
  public function makeOrder(Request $request) {

    $selectProduct = Product::find($request->product_id);
    if (!blank($selectProduct)) {
      $razorOrder = $this->api->order->create([
        'receipt' => $selectProduct->name,
        'amount' => $selectProduct->amount * 100,
        'currency' => 'INR',
      ]);
      Product::find($selectProduct->id)->update([
        'transaction_id' => $razorOrder->id,
          'status' => '1'
        ]);
      return view('razorpay.payment', [
        'razorOrder' => $razorOrder,
        'selectProduct' => $selectProduct
      ]);

    } else {
      return redirect()->route('productList');
    }

  }

  public function success(Request $request) {
    $paymentId = isset($request->payment_id) ? $request->payment_id : null;
    if (!blank($paymentId)) {
      $paymentDetails = $this->api->payment->fetch($paymentId);
      if ($paymentDetails->status == 'captured' || $paymentDetails->status == 'authorized') {
        Product::where('transaction_id',$paymentDetails->order_id)
                  ->update([
                    'transaction_id' => $paymentDetails->id,
                    'status' => '2'
                    ]);
      }
      return redirect()->route('productList')->with('success', 'Payment has been done successfully');
    } else {
      return redirect()->route('productList')->with('error', 'Payment ID not found');
    }

  }
}