@extends('layouts.app')
@section('content')
<div class="container">
  @if(session()->has('success'))
  <div class="alert alert-success">
    {{  session()->get('success') }}
  </div>
  @endif
  
  @if(session()->has('error'))
  <div class="alert alert-danger">
    {{  session()->get('error') }}
  </div>
  @endif
  
  <div class="row">
    @foreach ($products as $product)
    <div class="col-sm-12 col-md-4">
      <h1>{{$product->name}}</h1>
      <h5>Rs {{$product->amount}}</h5>
      <form action="{{ route('razorpay.makorder') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id  }}">
        <button type="submit">Buy Product</button>
      </form>
    </div>
    @endforeach
  </div>
</div>
@endsection