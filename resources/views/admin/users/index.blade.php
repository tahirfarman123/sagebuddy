@extends('layouts.app')
@section('content')
<div class="">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-4 col-md-3 col-sm-12">
          <h1 class="m-0 mb-2 font-weight-bold" style="font-size: 28px;">Sub Users</h1>
          <p class="m-0 text-mute breadc-text">User
            <span>/</span> index
          </p>
        </div>
        <div
          class="col-lg-8 col-md-9 col-sm-12 justify-content-end align-self-center gap-11 d-flex flex-row flex-sm-row">
          <button class="btn btn-primary" data-toggle="modal" data-target="#add-user">
            Add Sub User
          </button>
        </div>
      </div>
    </div>
  </div>
  <section class="section">

    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">

            <br>
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  {{-- <th scope="col">Public / Private</th> --}}
                  {{-- <th scope="col">Myshopify Domain</th> --}}
                  <th scope="col">Created Date</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @isset($users)
                @foreach($users as $user)
                <tr>
                  <th scope="row">{{$user->id}}</th>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{date('F d Y', strtotime($user->created_at))}}</td>
                  {{-- <td>{{$user->myshopify_domain}}</td> --}}
                  <td>
                    <a class="user-e" href="#" data-user="{{ $user }}" data-toggle="modal" data-target="#edit-user">
                      <i class="nav-icon uil uil-edit"></i>
                    </a>
                    <a href="#" class="user-de" data-toggle="modal" data-target="#delete-user"
                      data-userid="{{ $user->id }}">
                      <i class="nav-icon uil uil-trash"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
                @endisset
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="add-user">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{route('admin.users.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Add User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class='row'>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="url">Full Name</Label>
                <Input tabIndex="3" type="text" class="form-control Input" name="name" placeholder='Full Name'
                  value="" />
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_key">Email</Label>
                <Input tabIndex="4" type="email" class="form-control Input" name="email" placeholder='abc@oscorb.com'
                  value="">
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_secret_key">Password</Label>
                <Input tabIndex="5" type="password" class="form-control Input" name="Password" placeholder='******'
                  value="">
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Assign Store</Label>
                <div class="select2-purple">
                  <select class="select2" multiple="multiple" name="select_store[]"
                    data-dropdown-css-class="select2-purple" data-placeholder="Select a State" style="width: 100%;">
                    @foreach ($stores as $store)
                    <option value="{{ $store->table_id }}">{{
                      $store->name
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Assign Role</Label>
                <div class="select2-purple">
                  <select class="select2" multiple="multiple" name="select_role[]"
                    data-dropdown-css-class="select2-purple" data-placeholder="Select a State" style="width: 100%;">
                    @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{
                      $role->name
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-12 col-md-12 col-sm-12'>
              <div>
                <Label for="access_token">Assign Permission</Label>
                <div class="select2-purple">
                  <select class="select2" multiple="multiple" name="select_permission[]"
                    data-dropdown-css-class="select2-purple" data-placeholder="Select a State" style="width: 100%;">
                    @foreach ($permission as $permi)
                    <option value="{{ $permi }}">{{
                      $permi
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="edit-user">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{route('admin.users.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="modal-header">
          <h4 class="modal-title">Update User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class='row'>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <input type="hidden" name="id" id="id" value="">
                <Label for="url">Full Name</Label>
                <input tabIndex="3" type="text" class="form-control Input" id="name" name="name" placeholder='Full Name'
                  value="" />
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_key">Email</Label>
                <Input tabIndex="4" type="email" class="form-control Input" id="email" name="email"
                  placeholder='abc@oscorb.com' value="">
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_secret_key">Password</Label>
                <Input tabIndex="5" type="password" class="form-control Input" name="Password" placeholder='******'
                  value="">
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Assign Store</Label>
                <div class="select2-purple">
                  <select class="select2" multiple="multiple" id="select_store" name="select_store[]"
                    data-dropdown-css-class="select2-purple" data-placeholder="Select a State" style="width: 100%;">
                    @foreach ($stores as $store)
                    <option value="{{ $store->table_id }}">{{
                      $store->name
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Assign Role</Label>
                <div class="select2-purple">
                  <select class="select2" multiple="multiple" id="select_role" name="select_role[]"
                    data-dropdown-css-class="select2-purple" data-placeholder="Select a State" style="width: 100%;">
                    @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{
                      $role->name
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-12 col-md-12 col-sm-12'>
              <div>
                <Label for="access_token">Assign Permission</Label>
                <div class="select2-purple">
                  <select class="select2" multiple="multiple" id="select_permission" name="select_permission[]"
                    data-dropdown-css-class="select2-purple" data-placeholder="Select a State" style="width: 100%;">
                    @foreach ($permission as $permi)
                    <option value="{{ $permi }}">{{
                      $permi
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="delete-user">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form action="" id="delete-form" method="post" enctype="multipart/form-data">
        @csrf
        @method('delete')
        <div class="modal-header">
          <h4 class="modal-title">Delete User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-5">
          <p>Are you Sure Want to Delete User!</p>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="submit" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
        </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



@endsection


@section('scripts')
<script>
  $('.user-e').on('click', function(){
    var userdata = $(this).data('user');
    console.log(userdata.id);
    $('#id').val(userdata.id);
    $('#name').val(userdata.name);
    $('#email').val(userdata.email);
    const stores = userdata.store_id.split(",");

    // No need for a separate array and $.each loop, you can directly set the values to the select element
    $('#select_store').val(stores).trigger('change');
    var roles = [];
    $.each( userdata.roles, function( key, value ) {
      roles.push(value.name);
    });
    
    $('#select_role').val(roles).trigger('change');
    var permissions = [];
    $.each(userdata.permissions, function(key, value) {
      permissions.push(value.name);
    });
    $('#select_permission').val(permissions).trigger('change');
  });
  $('.user-de').on('click', function(){
    var userdata = $(this).data('userid');
    const url = "{{ route('admin.users.destroy', ['id' => ':id']) }}";
    $('#delete-form').attr('action', url.replace(':id', userdata));

  });


</script>
@endsection