@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <p><b>Product Name : </b>{{ $selectProduct->name }}</p>
      <p><b>Product Amount : </b>Rs {{ $selectProduct->amount }}</p>
      <button id="rzp-button1" class="btn btn-info">Make Payment</button>
    </div>
  </div>
</div>
@endsection

@push('js')

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var success = "{{ route('razorpay.success') }}";
var options = {
    "key": "{{env('RAZORPAY_KEY')}}", // Enter the Key ID generated from the Dashboard
    "amount": "{{ $razorOrder->amount }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "Hello Kalpesh",
    "description": "Test Transaction",
    "image": "https://example.com/your_logo",
    "order_id": "{{ $razorOrder->id }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "handler": function (response){
      window.location.href=success +'?payment_id='+response.razorpay_payment_id;
        //alert(response.razorpay_payment_id);
        //alert(response.razorpay_order_id);
        //alert(response.razorpay_signature)
    },
    "prefill": {
        "name": "Gaurav Kumar",
        "email": "gaurav.kumar@example.com",
        "contact": "9000090000"
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
        alert(response.error.code);
        alert(response.error.description);
        alert(response.error.source);
        alert(response.error.step);
        alert(response.error.reason);
        alert(response.error.metadata.order_id);
        alert(response.error.metadata.payment_id);
});
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
@endpush