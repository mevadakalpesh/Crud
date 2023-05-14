@extends('layouts.app')
@section('content')
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
<h1 class="mb-5 mt-5">Roles</h1>
<a href="{{ route('role.create') }}" class="btn btn-primary" >
  Add Role
</a>
<table class="table table-bordered data-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Created At</th>
      <th>action</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

@endsection

@push('js')
<script type="text/javascript">
  $(function() {
    var table = $('.data-table').DataTable( {
      processing: true,
      serverSide: true,
      ajax: "{{ route('role.index') }}",
      columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
      },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'created_at',
          name: 'created_at'
        },
        {
          data: 'action',
          name: 'action'
        },
      ]
    });

    $(document).on('click', '.role-delete', function(e) {
      if (confirm('are you sure .!')) {
        var role_id = $(this).attr('data-role_id');
        var role_delete_url = '{{ route("role.destroy","0") }}';
        role_delete_url = role_delete_url.replace('/0', '/' + role_id);

        $.ajax( {
          url: role_delete_url,
          type: "DELETE",
          success: function(data) {
            if (data.status == 200) {
              table.ajax.reload();
              toastr.success(data.message);
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
        });
      }
    });

  });
</script>
@endpush