@extends('layouts.app')
@section('content')
<div class="">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-4 col-md-3 col-sm-12">
          <h1 class="m-0 mb-2 font-weight-bold" style="font-size: 28px;">Users</h1>
          <p class="m-0 text-mute breadc-text">User
            <span>/</span> index
          </p>
        </div>
        <div
          class="col-lg-8 col-md-9 col-sm-12 justify-content-end align-self-center gap-11 d-flex flex-row flex-sm-row">
          <button class="btn btn-primary" data-toggle="modal" data-target="#add-user">
            Add User
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
                  <th scope="col">Role</th>
                  {{-- <th scope="col">Public / Private</th> --}}
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
                  <td>
                    @foreach ($user->roles as $role)
                    <span class="badge bg-success">
                      {{ $role->name}}
                    </span>
                    @endforeach
                  </td>
                  <td>{{date('F d Y', strtotime($user->created_at))}}</td>
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
      <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Add User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class='row'>
            <div class='col-lg-6 col-md-12 col-sm-12'>
              <div>
                <Label for="storename">Full Name <span class='text-danger'>*</span></Label>
                <Input tabIndex="1" type="text" class="form-control Input" name="name" placeholder='Full Name' id="name"
                  value="">
              </div>

            </div>
            {{-- <div class='col-lg-4 col-md-6 col-sm-12'>
              <div>
                <Label for="phonenumber">Phone Number</Label>
                <Input tabIndex="2" type="text" class="form-control Input" name="phonenumber" placeholder='Phone Number'
                  id="phonenumber" value="">
              </div>
            </div> --}}
            <div class='col-lg-6 col-md-12 col-sm-12'>
              <div>
                <Label for="email">Email</Label>
                <Input tabIndex="2" type="email" class="form-control Input" placeholder='example@shopify.com'
                  name="email" id="email" value="">
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Assign Role</Label>
                <div class="select2-purple">
                  <select class="select2" style="width: 100%;" multiple="multiple" name="select_role[]"
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
            <div class='col-lg-6 col-md-12 col-sm-12'>
              <div>
                <Label for="access_token">Assign Permission</Label>
                <div class="select2-purple">
                  <select class="select2" multiple="multiple" name="select_permission[]"
                    data-dropdown-css-class="select2-purple" data-placeholder="Select a State" style="width: 100%;">
                    @foreach ($permissions as $permission)
                    <option value="{{ $permission }}">{{
                      $permission
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="currency_id">Store Currency</Label>
                <select name="currency_id" class="select2 form-control Input" style="width: 100% " id="">
                  <option value="">Select Currency</option>
                  @foreach ($currencies as $currency)
                  <option value="{{ $currency->id }}">{{ $currency->name }} - {{ $currency->code }} - {{
                    $currency->symbol }}</option>
                  @endforeach
                  <option value=""></option>
                </select>
              </div>
            </div>
            {{-- <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="url">Shopify Store Url</Label>
                <Input tabIndex="3" type="text" class="form-control Input" name="myshopify_domain"
                  placeholder='example.shopify.com' id="url" value="" />
              </div>

            </div> --}}
            {{-- <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_key">API Key</Label>
                <Input tabIndex="4" type="text" class="form-control Input" name="api_key" placeholder='API Key'
                  id="api_key" value="">
              </div>

            </div> --}}
            {{-- <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_secret_key">API Secret Key</Label>
                <Input tabIndex="5" type="text" class="form-control Input" name="api_secret_key"
                  placeholder='Api Secret Key' id="api_secret_key" value="">
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Access Token</Label>
                <Input tabIndex="6" type="text" class="form-control Input" name="access_token" id="access_token"
                  placeholder='Access Token' value="">
              </div>
            </div> --}}
            {{-- <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Store Image</Label>
                <Input tabIndex="6" type="file" class="form-control Input" name="image" id="image">
              </div>
            </div>
            <div class='col-lg-6 col-md-12 col-sm-12 mt-3 '>
              <p>Account Details</p>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Account Email</Label>
                <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" required>
                @error('email')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
              </div>
            </div> --}}
            <div class='col-lg-6 col-md-12 col-sm-12'>
              <div>
                <Label for="access_token">Password</Label>
                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}"
                  required>
                @error('password')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
          </div>

        </div>
        {{-- <div class='row'>
          <h5 class='py-4'><b>Advance</b></h5>
        </div>
        <div class='row'>
          <div class='col-lg-4 col-md-6 col-sm-12'>
            <div>
              <div switch>
                <Input type="switch" id="fullfillment_notification" name="fullfillment_notification" checked="" />
                <Label check><b> Push Fulfilment Status to
                    Shopify</b></Label>
              </div>
              <p class='py-3'>Oscorb Retail will update the order status in Shopify whenever order status
                changes in Oscorb Retail.</p>

            </div>

          </div>
          <div class='col-lg-4 col-md-6 col-sm-12'>
            <div>
              <Label>
                Take Stock
              </Label>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="take_stock" id="flexRadioDefault1" checked />
                <label class="form-check-label" htmlFor="flexRadioDefault1">
                  From all your Oscorb Retail locations
                </label>
              </div>
              <div class="form-check pb-3">
                <input class="form-check-input" type="radio" name="take_stock" id="flexRadioDefault2" />
                <label class="form-check-label" htmlFor="flexRadioDefault2">
                  From Specific Location
                </label>
              </div>
            </div>

          </div>
          <div class='col-lg-4 col-md-6 col-sm-12'>
            <div switch>
              <Input type="switch" id="sync_stock" name="sync_stock" checked={formData.sync_stock} />
              <Label check><b> Sync Stock Orders from
                  Shopify</b></Label>
            </div>
            <p class='py-3'>Oscorb Retail will automatically Sync Inventory
              to Shopify every
              15 Minutes</p>
          </div>
          <div class='col-lg-4 col-md-6 col-sm-12'>
            <div switch>
              <Input type="switch" id="sync_order" name="sync_order" checked={formData.sync_order} />
              <Label check><b> Auto Import Orders from
                  Shopify</b></Label>
            </div>
            <p class='py-3'>Oscorb Retail will automatically import orders
              from Shopify to Oscorb Retail every
              15 Minutes</p>
          </div>
          <div class='col-lg-4 col-md-6 col-sm-12'>


            <div switch>
              <Input type="switch" id="sync_price" name="sync_price" checked={formData.sync_price} />
              <Label check><b> Update Price on Shopify</b></Label>
            </div>
            <p class='py-3'>Oscorb Retail will automatically import orders
              from Shopify to Oscorb Retail every
              15 Minutes</p>
          </div>
          <div class='col-lg-4 col-md-6 col-sm-12'>
            <div switch>

              <Input type="switch" id="sync_product" name="sync_product" checked={formData.sync_product} />
              <Label check><b> Auto Import Product from
                  Shopify</b></Label>
              <p class='py-3'>Oscorb Retail will automatically import Product
                from Shopify to Oscorb Retail every
                15 Minutes</p>
            </div>

          </div>
        </div> --}}
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
      <form action="" id="edit-form" method="post" enctype="multipart/form-data">
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
                <input tabIndex="3" type="text" class="form-control Input" id="editname" name="name"
                  placeholder='Full Name' value="" />
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_key">Email</Label>
                <Input tabIndex="4" type="email" class="form-control Input" id="editemail" name="email"
                  placeholder='abc@oscorb.com' value="">
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_secret_key">Password</Label>
                <Input tabIndex="5" type="password" class="form-control Input" name="password" placeholder='******'
                  value="">
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="currency_id">Store Currency</Label>
                <select name="currency_id" class="select2 form-control Input" id="currency_id" style="width: 100% " id="">
                  <option value="">Select Currency</option>
                  @foreach ($currencies as $currency)
                  <option value="{{ $currency->id }}">{{ $currency->name }} - {{ $currency->code }} - {{
                    $currency->symbol }}</option>
                  @endforeach
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Assign Role</Label>
                <div class="select2-purple">
                  <select class="select2" style="width: 100%;" multiple="multiple" id="select_role" name="select_role[]"
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
                    @foreach ($permissions as $permission)
                    <option value="{{ $permission }}">{{
                      $permission
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
    console.log(userdata);
    const url = "{{ url('users/update') }}/" + userdata.id;
    $('#edit-form').attr('action', url);
    console.log(url);

    $('#user_id').val(userdata.id);
    $('#editname').val(userdata.name);
    $('#currency_id').val(userdata.currency_id).trigger('change');
    $('#editemail').val(userdata.email);
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
  
  });
</script>
@endsection