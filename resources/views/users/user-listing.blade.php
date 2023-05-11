@extends('layouts.app')
@section('content')
<h1 class="mb-5 mt-5">Users</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
  Add User
</button>
<table class="table table-bordered data-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Roles</th>
      <th>Created At</th>
      <th>action</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<!-- Add New User -->
<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserLabel">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('user.store') }}" method="POST" id="addUserForm">
        @csrf
        <div class="modal-body">

          <div class="form-group mt-2">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name" />
          </div>
          
          <div class="form-group mt-2">
            <label for="amount">Email</label>
            <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount" min="1" />
          </div>

          <div class="form-group mt-2">
            <label for="description">Password</label>
            <input type="password" name="password" id="password" class="form-control" />
          </div>

          <div class="form-group mt-2">
            <label for="status">Role</label>
            <select multiple name="status[]" class="form-control" id="status">
              @foreach($roles as $role)
              <option value="{{$role->id}}">{{$role->name}}</option>
              @endforeach
            </select>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- edit New User -->
<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserLabel">Edit User #<span id="edit_user_id">0</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="editUserForm">
        @csrf
        @method("PUT")
        <div class="modal-body" id="edit_user_body">

          <div class="form-group mt-2">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="edit_name" placeholder="Name" />
          </div>
          
          <div class="form-group mt-2">
            <label for="amount">Amount</label>
            <input type="text" name="amount" class="form-control" id="edit_amount" placeholder="Amount" min="1" />
          </div>

          <div class="form-group mt-2">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="edit_description" rows="3"></textarea>
          </div>

          <div class="form-group mt-2">
            <label for="status">Status</label>
            <select name="status" class="form-control" id="edit_status">
              <option value="1">Pending</option>
              <option value="2">Completed</option>
            </select>
          </div>

          <div class="form-group mt-2">
            <label for="image">Image</label>
            <input name="image" type="file" class="form-control" id="edit_image" placeholder="Image">
            <img id="edit_priview_image" class="listing-image" src="#" alt="preview" />
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection

@push('js')
<script type = "text/javascript" >
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'roles',
                    name: 'roles'
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

        $(document).on('click', '.user-delete', function(e) {
            if (confirm('are you sure .!')) {
                var user_id = $(this).attr('data-user_id');
                var user_delete_url = '{{ route("user.destroy","0") }}';
                user_delete_url = user_delete_url.replace('/0', '/' + user_id);

                $.ajax({
                    url: user_delete_url,
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

        //Add User start
        $('#addUserForm').bootstrapValidator({
            live: 'enabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Name is required and cannot be empty'
                        }
                    }
                },
                amount: {
                    validators: {
                        notEmpty: {
                            message: 'Amount is required and cannot be empty'
                        }
                    }
                },
                status: {
                    validators: {
                        notEmpty: {
                            message: 'Status is required and cannot be empty'
                        }
                    }
                },
                image: {
                    validators: {
                        notEmpty: {
                            message: 'Image is required and cannot be empty'
                        },
                    }
                }
            },
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            var formData = new FormData(this)
            var form = $(e.target);

            //var bv = $form.data('bootstrapValidator');
            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: formData,
                success: function(data) {
                    if (data.status == 200) {
                        $('#addUserForm').trigger('reset');
                        $('#addUser').modal('hide');
                        toastr.success(data.message);
                        table.ajax.reload();
                        $('#priview_image').attr('src', '#')
                    } else {
                        toastr.error(data.message);
                    }

                },
                error: function(e) {
                    console.log(e);
                    alert(e);
                },
                cache: false,
                contentType: false,
                processData: false

            })
        });
        //Add User end

        //Edit User start

        $('#editUserForm').bootstrapValidator({
            live: 'enabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Name is required and cannot be empty'
                        }
                    }
                },
                amount: {
                    validators: {
                        notEmpty: {
                            message: 'Amount is required and cannot be empty'
                        }
                    }
                },
                status: {
                    validators: {
                        notEmpty: {
                            message: 'Status is required and cannot be empty'
                        }
                    }
                },
            },
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            let formDataUpdate = new FormData(this);
            var form = $(e.target);
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                processData: false,
                contentType: false,
                data: formDataUpdate,
                success: function(data) {
                    if (data.status == 200) {
                        $('#editUserForm').trigger('reset');
                        $('#editUser').modal('hide');
                        toastr.success(data.message);
                        table.ajax.reload();
                        $('#priview_image').attr('src', '#')
                    } else {
                        toastr.error(data.message);
                    }
                }
            });

        });
        //Edit User end

        $(document).on('click', '.user-edit', function(e) {
            var user_id = $(this).attr('data-user_id');
            var user_get_url = '{{ route("user.edit","0") }}';
            user_get_url = user_get_url.replace('/0', '/' + user_id);

            $.ajax({
                url: user_get_url,
                type: "GET",
                success: function(data) {
                    if (data.status == 200) {
                        console.log('data', data);
                        var user_update_url = '{{ route("user.update",0) }}';
                        user_update_url = user_update_url.replace('/0', '/' + data.result.id);
                        $('#editUserForm').attr('action', user_update_url);
                        $('#edit_user_id').text(data.result.id);
                        $('#edit_user_body #edit_name').val(data.result.name);
                        $('#edit_user_body #edit_amount').val(data.result.amount);
                        $('#edit_user_body #edit_status').val(data.result.status);
                        $('#edit_user_body #edit_description').val(data.result.description);
                        $('#edit_user_body #edit_priview_image').show();
                        $('#edit_user_body #edit_priview_image').attr('src', data.result.image);
                        $('#editUser').modal('show');
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
        $('#priview_image').hide();

        $('#image').change(function(e) {
            const [file] = this.files
            if (file) {
                $('#priview_image').show();
                priview_image.src = URL.createObjectURL(file)
            } else {
                $('#priview_image').hide();
            }
        });

        $('#edit_priview_image').hide();
        $('#edit_image').change(function(e) {

            const [file] = this.files;
            if (file) {
                $('#edit_priview_image').show();
                $('#edit_priview_image').attr('src', URL.createObjectURL(file));
            } else {
                $('#edit_priview_image').hide();
            }
        });

    });
</script>
@endpush