@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <h3>Add Role</h3>
  </div>
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
  
  <form id="" action="{{ route('role.store') }}" method="POST">
    @csrf
    <div class="form-group mt-2">
      <label for="name">Name</label>
      <input type="text" name="name" class="form-control" id="name" placeholder="Name" />
  </div>

  <div class="row">
    <h5>Permissions</h5>
    @foreach($permissions as $permission)
    <div class="com-md-3 col-sm-12">

      <div class="form-group mt-2">
        <label for="permission-{{$permission->id}}">{{ $permission->name }}</label>
        <input type="checkbox" name="permissions[]" value="{{$permission->id}}" id="permission-{{$permission->id}}" />
    </div>
   
  </div>
  @endforeach
</div>
 <button type="submit" class="btn btn-info">submit</button>
</form>

</div>

@endsection