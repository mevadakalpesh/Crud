@extends('layouts.app')
@section('content')
<div class="container">
  @if(session()->has('error'))
  <div class="alert alert-danger">
    {{ session()->get('error') }}
  </div>
  @endif

  @if(session()->has('success'))
  <div class="alert alert-success">
    {{ session()->get('success') }}
  </div>
  @endif

  <div id="progress-section" style="display:none;">
    
  </div>


  <form enctype="multipart/form-data" class="form-inline" action="{{ route('uploadFile') }}" method="POST" id="import-form">
    @csrf
    <div class="form-group mb-2">
      <label for="staticEmail2" class="sr-only">File Upload</label>
      <input type="file" class="form-control-plaintext" name="file" id="import-file">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Upload</button>
  </form>
</div>
@endsection

@push('js')
<script>
var apiTimer = null;
var intervalTime = 1000;
  $('#import-form').submit(function(e) {
    
    e.preventDefault();
    let formData = new FormData(this);
    let form = $(this);
    $.ajax( {
      url: form.attr('action'),
      type: "POST",
      data: formData,
      success: function(data) {
        console.log(data);
        if (data.status == 200) {
          localStorage.setItem('batch_id', data.result.id);
          console.log(data.result.id);
          startLoading();
        } else {
          toastr.error(data.message);
        }
      },
      error: function(e) {
        console.log(e);
      },
      cache: false,
      contentType: false,
      processData: false
    })
  });
  startLoading();
  function startLoading() {
  var getBatchByIdUrl = "{{ route('getBatchById','DUMYID') }}";
    let batchId = localStorage.getItem('batch_id');
    getBatchByIdUrl = getBatchByIdUrl.replace('/DUMYID','/'+batchId);
    if (batchId) {
    // apiTimer = setInterval(getBatchData(getBatchByIdUrl,batchId),intervalTime);
    apiTimer = setInterval(function() {
      getBatchData(getBatchByIdUrl,batchId);
    }, intervalTime);
    }
  }
  
  function getBatchData(batchUrl,batchId){
      
      $('#import-form').hide();
      $('#progress-section').show();
      $.ajax({
        url: batchUrl,
        method: "GET",
        dataType:'JSON',
        data: {batchId:batchId},
        success: function(data) {
          console.log('startLoading',data);
          if (data.status == 200) {
            //data.result.progress
            //data.result.totalJobs
            //data.result.processedJobs
            //data.result.pendingJobs
            var htmlData = '<div class="progress"><div class="progress-bar" role="progressbar" style="width: '+data.result.progress+'%;" aria-valuenow="'+data.result.progress+'" aria-valuemin="0" aria-valuemax="100">'+data.result.progress+'%</div></div><p>'+data.result.processedJobs+' completed out of '+data.result.totalJobs+'</p>';
            $('#progress-section').html(htmlData);
            if(data.result.progress == 100){
              clearInterval(apiTimer);
              apiTimer = null;
              localStorage.removeItem('batch_id');
              $('#import-form').reset();
              $('#import-form').show();
              $('#progress-section').hide();
              toastr.success('File has been impored Successfully..!');
            }
          } else {
            toastr.error(data.message);
          }
        },
        error: function(e) {
          console.log(e);
        },
       // cache: false,
        //contentType: false,
        //processData: false
      });
  }

</script>
@endpush