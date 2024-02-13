@extends('layouts.app')
@section('content')
<div class="">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-4 col-md-3 col-sm-12">
          <h1 class="m-0 mb-2 font-weight-bold" style="font-size: 28px;">Stores</h1>
          <p class="m-0 text-mute breadc-text">Store
            <span>/</span> index
          </p>
        </div>
        <div
          class="col-lg-8 col-md-9 col-sm-12 justify-content-end align-self-center gap-11 d-flex flex-row flex-sm-row">
          <button class="btn btn-primary add-store" data-toggle="modal" data-target="#add-store">
            Add Store
          </button>
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="row">
      @foreach($stores as $store)
      <div class="col-lg-3 col-md-3 col-sm-4">
        <div class="small-box card hide-drop-icon">
          <div class="btn-group" style="float: right; margin-right: 10px; margin-top: 10px">
            <button type="button" style="background: transparent; border: none;" class="dropdown-toggle dropdown-icon"
              data-toggle="dropdown" aria-expanded="false">
              <span class=""><i class="uil uil-ellipsis-v"></i></span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
              <a class="dropdown-item store-e" href="#" data-store="{{ $store }}" data-toggle="modal"
                data-target="#add-edit">Update</a>
              {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sync-order">Edit</a> --}}
              <a class="dropdown-item delete-store" href="" data-filter="{{ $store->table_id }}" data-toggle="modal"
                data-target="#delete-store">Delete</a>
              <a class="dropdown-item" href="#">Cancel</a>
            </div>
          </div>
          <div class="text-center inner" style=" text-align: center , padding: 5px">
            <div class='mb-3 logo-div'>
              {{-- <i class=" fas uil uil-store" style="font-size: 40px"></i> --}}
              @if ($store->image == null)
              <img src="{{ asset('dist/img/icon.png') }}" width="70px" alt="">
              @else
              <img src="{{ asset('')}}{{$store->image}}" alt="" width="70px">
              @endif
            </div>
            <h6 style=" font-size: 14px , font-weight: 600 ">{{$store->name}}</span></h6>
          </div>

        </div>
      </div>
      @endforeach
    </div>
  </section>
</div>

<div class="modal fade" id="add-store">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="{{route('stores.store')}}" id="add-store-form" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Add Store</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class='row'>
            {{-- <div class='col-lg-4 col-md-6 col-sm-12'>
              <div>
                <Label for="storename">Store Name <span class='text-danger'>*</span></Label>
                <Input tabIndex="1" type="text" class="form-control Input" name="storename" placeholder='Store Name'
                  id="storename" value="">
              </div>

            </div> --}}
            {{-- <div class='col-lg-4 col-md-6 col-sm-12'>
              <div>
                <Label for="phonenumber">Phone Number</Label>
                <Input tabIndex="2" type="text" class="form-control Input" name="phonenumber" placeholder='Phone Number'
                  id="phonenumber" value="">
              </div>
            </div> --}}
            {{-- <div class='col-lg-4 col-md-6 col-sm-12'>
              <div>
                <Label for="email">Email</Label>
                <Input tabIndex="2" type="email" class="form-control Input" placeholder='example@shopify.com'
                  name="email" id="email" value="">
              </div>
            </div> --}}
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="url">Shopify Store Url</Label>
                <Input tabIndex="3" type="text" class="form-control Input" name="myshopify_domain"
                  placeholder='example.shopify.com' value="" required />
              </div>

            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="api_key">API Key</Label>
                <Input tabIndex="4" type="text" class="form-control Input" name="api_key" placeholder='API Key' value=""
                  required>
              </div>

            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="api_secret_key">API Secret Key</Label>
                <Input tabIndex="5" type="text" class="form-control Input" name="api_secret_key"
                  placeholder='Api Secret Key' value="" required>
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="access_token">Access Token</Label>
                <Input tabIndex="6" type="text" class="form-control Input" name="access_token"
                  placeholder='Access Token' value="" required>
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="access_token">Store Image</Label>
                <Input tabIndex="6" type="file" class="form-control Input" name="image">
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="currency_id">Store Currency</Label>
                <div class="select2-purple">
                  <select name="currency_id" class="select2 form-control Input" data-dropdown-css-class="select2-purple"
                    data-placeholder="Select a Currency" style="width: 100% " id="">
                    <option value="">Select Currency</option>
                    @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->name }} - {{ $currency->code }} - {{
                      $currency->symbol }}</option>
                    @endforeach
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12 mt-3 '>
              <div>
                <Label for="access_token">Add New User Or Assign to to Existing User</Label>
                <div class="select2-purple">
                  <select style="width: 100%;" id="select-user-type" name="select_user_type" class="form-control Input">
                    <option value="newuser">New User</option>
                    <option value="existing">Existing User</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12 mt-3 '>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 mt-3 existing'>
              <div>
                <Label for="access_token">Assign to User</Label>
                <div class="select2-purple">
                  <select style="width: 100%;" name="assign_to_user" class="form-control Input">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{
                      $user->name
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-12 col-md-6 col-sm-12 mt-3 newuser'>
              <p>Account Details</p>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 newuser'>
              <div>
                <Label for="access_token">User Name</Label>
                <input type="text" class="form-control Input" name="name" id="name" placeholder="Enter User Name"
                  value="">
                @error('email')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 newuser'>
              <div>
                <Label for="access_token">Account Email</Label>
                <input type="email" class="form-control Input" name="email" placeholder="Enter User Email"
                  value="{{old('email')}}">
                @error('email')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 newuser'>
              <div>
                <Label for="access_token">Account Password</Label>
                <input type="password" class="form-control Input" name="password" placeholder="******"
                  value="{{old('password')}}">
                @error('password')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 newuser'>
              <div>
                <Label for="access_token">Assign Role</Label>
                <div class="select2-purple">
                  <select class="select2 form-control Input" style="width: 100%;" multiple="multiple"
                    name="select_role[]" data-dropdown-css-class="select2-purple" data-placeholder="Select a State"
                    style="width: 100%;">
                    @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{
                      $role->name
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-12 col-md-12 col-sm-12 newuser'>
              <div>
                <Label for="access_token">Assign Permission</Label>
                <div class="select2-purple">
                  <select class="select2 form-control Input permissionselect" multiple="multiple"
                    name="select_permission[]" data-dropdown-css-class="select2-purple"
                    data-placeholder="Select a State" style="width: 100%;">
                    <option value="all">All Permission</option>
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
<div class="modal fade" id="add-edit">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="" id="form-edit" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="modal-header">
          <h4 class="modal-title">Edit Store</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="store_id" id="store_id">
          <div class='row'>
            {{-- <div class='col-lg-4 col-md-6 col-sm-12'>
              <div>
                <Label for="storename">Store Name <span class='text-danger'>*</span></Label>
                <Input tabIndex="1" type="text" class="form-control Input" name="storename" placeholder='Store Name'
                  id="storename" value="">
              </div>

            </div> --}}
            {{-- <div class='col-lg-4 col-md-6 col-sm-12'>
              <div>
                <Label for="phonenumber">Phone Number</Label>
                <Input tabIndex="2" type="text" class="form-control Input" name="phonenumber" placeholder='Phone Number'
                  id="phonenumber" value="">
              </div>
            </div> --}}
            {{-- <div class='col-lg-4 col-md-6 col-sm-12'>
              <div>
                <Label for="email">Email</Label>
                <Input tabIndex="2" type="email" class="form-control Input" placeholder='example@shopify.com'
                  name="email" id="email" value="">
              </div>
            </div> --}}
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="url">Shopify Store Url</Label>
                <Input tabIndex="3" type="text" class="form-control Input" name="myshopify_domain" id="myshopify_domain"
                  placeholder='example.shopify.com' value="" />
              </div>

            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="api_key">API Key</Label>
                <Input tabIndex="4" type="text" class="form-control Input" name="api_key" placeholder='API Key'
                  id="api_key" value="">
              </div>

            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="api_secret_key">API Secret Key</Label>
                <Input tabIndex="5" type="text" class="form-control Input" name="api_secret_key"
                  placeholder='Api Secret Key' id="api_secret_key" value="">
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="access_token">Access Token</Label>
                <Input tabIndex="6" type="text" class="form-control Input" name="access_token" id="access_token"
                  placeholder='Access Token' value="">
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="access_token">Store Image</Label>
                <Input tabIndex="6" type="file" class="form-control Input" name="image" id="image">
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12'>
              <div>
                <Label for="currency_id">Store Currency</Label>
                <div class="select2-purple">
                  <select name="currency_id" id="currency_id" class="select2 form-control Input"
                    data-dropdown-css-class="select2-purple" data-placeholder="Select a Currency" style="width: 100% "
                    id="">
                    <option value="">Select Currency</option>
                    @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->name }} - {{ $currency->code }} - {{
                      $currency->symbol }}</option>
                    @endforeach
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12 mt-3 '>
              <div>
                <Label for="access_token">Add New User Or Assign to to Existing User</Label>
                <div class="select2-purple">
                  <select style="width: 100%;" id="select-user-type1" name="select_user_type"
                    class="form-control Input">
                    <option value="newuser">New User</option>
                    <option value="existing">Existing User</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12 mt-3 '>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 mt-3 existing'>
              <div>
                <Label for="access_token">Assign to User</Label>
                <div class="select2-purple">
                  <select style="width: 100%;" name="assign_to_user" id="assign_to_user" class="form-control Input">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{
                      $user->name
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-12 col-md-6 col-sm-12 mt-3 newuser'>
              <p>Account Details</p>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 newuser'>
              <div>
                <Label for="access_token">Account Email</Label>
                <input type="email" class="form-control Input" name="email" id="email" value="{{old('email')}}"
                  required>
                @error('email')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 newuser'>
              <div>
                <Label for="access_token">User Name</Label>
                <input type="text" class="form-control Input" name="name" id="name" value="">
                @error('email')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 newuser'>
              <div>
                <Label for="access_token">Account Password</Label>
                <input type="password" class="form-control Input" id="password" name="password"
                  value="{{old('password')}}" required>
                @error('password')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class='col-lg-4 col-md-4 col-sm-12 newuser'>
              <div>
                <Label for="access_token">Assign Role</Label>
                <div class="select2-purple">
                  <select class="select2 form-control Input" style="width: 100%;" multiple="multiple"
                    name="select_role[]" id="select_role" data-dropdown-css-class="select2-purple"
                    data-placeholder="Select a State" style="width: 100%;">
                    @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{
                      $role->name
                      }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class='col-lg-12 col-md-12 col-sm-12 newuser'>
              <div>
                <Label for="access_token">Assign Permission</Label>
                <div class="select2-purple">
                  <select class="select2 form-control Input permissionselect" id="permissionselect" multiple="multiple"
                    name="select_permission[]" data-dropdown-css-class="select2-purple"
                    data-placeholder="Select a State" style="width: 100%;">
                    <option value="all">All Permission</option>
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
<div class="modal fade" id="delete-store">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form action="" id="delete-form" method="post" enctype="multipart/form-data">
        @csrf
        @method('delete')
        <div class="modal-header">
          <h4 class="modal-title">Store Delete</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <div class="row" class="texe-center">
            <p>Are you Sure want to Delete Store !</p>
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="submit" class="btn btn-danger">Delete</button>
          <button class="btn btn-warning" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
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
  $('.delete-store').on('click', function(){
    var filterdata = $(this).data('filter');
    const url = "{{ route('stores.destroy', ['store' => ':store']) }}";
    $('#delete-form').attr('action', url.replace(':store', filterdata));
  });
  $('.existing').hide();
  $('#select-user-type').on('change', function(){
    var value = $(this).val();
    if(value == 'existing'){
      $('.newuser').hide();
      $('.existing').show();
    }
    if(value == 'newuser'){
      $('.existing').hide();
      $('.newuser').show();
    }
    
  });
  $('#select-user-type1').on('change', function(){
    var value = $(this).val();
    if(value == 'existing'){
      $('.newuser').hide();
      $('.existing').show();
      var form = document.getElementById('add-store-form');
      form.querySelector('input[name="email"]');
      form.querySelector('input[name="password"]');

    }
    if(value == 'newuser'){
      $('.existing').hide();
      $('.newuser').show();
    }
    
  });
  $('.add-store').on('click', function(){
    $('.existing').hide();
    $('.newuser').show();

  //   $('#store_id').val('');
  //   $('#myshopify_domain').val('');
  //   $('#api_key').val('');
  //   $('#api_secret_key').val('');
  //   $('#access_token').val('');
  //   $('#currency_id').val('');
  //   $('#email').val('');
  //   $('#currency_id').val('').trigger('change');

  //   $('#select-user-type').val('newuser').trigger('change');
   
  //   $('#permissionselect').val('').trigger('change');
  //   $('#assign_to_user').val('').trigger('change');
  //   $('#select_role').val('').trigger('change');
  //   $('#permissionselect').val('').trigger('change');
  });
  $('.store-e').on('click', function(){
    document.getElementById("email").required = false;
    document.getElementById("password").required = false;
    $('#store_id').val('');
    $('#myshopify_domain').val('');
    $('#name').val('');
    $('#api_key').val('');
    $('#api_secret_key').val('');
    $('#access_token').val('');
    $('#currency_id').val('').trigger('change').val('');
    $('#select-user-type').val('').trigger('change');
    $('#email').val('');
    $('#select-user-type').val('newuser').trigger('change');
    $('#permissionselect').val('').trigger('change');
    $('#assign_to_user').val('').trigger('change');
    $('#select_role').val('').trigger('change');
    $('#permissionselect').val('').trigger('change');


    var storedata = $(this).data('store');
    const url = "{{ route('stores.update', ['store' => ':store']) }}";
    $('#form-edit').attr('action', url.replace(':store', storedata.table_id));
    console.log(storedata);
    $('#store_id').val(storedata.table_id);
    $('#myshopify_domain').val(storedata.myshopify_domain);
    $('#email').val(storedata.users['email']);
    $('#api_key').val(storedata.api_key);
    $('#api_secret_key').val(storedata.api_secret_key);
    $('#access_token').val(storedata.access_token);
    $('#name').val(storedata.users.name);
    $('#currency_id').val(storedata.currency_id).trigger('change');
    $('#email').val(storedata.email);

    var roles = [];
    $.each( storedata.users.roles, function( key, value ) {
      roles.push(value.name);
    });
    $('#permissionselect').val(roles).trigger('change');

    $('#select_role').val(roles).trigger('change');
    var permissions = [];
    $.each( storedata.users.permissions, function( key, value ) {
      permissions.push(value.name);
    });
    $('#assign_to_user').val(storedata.user_id).trigger('change');
    $('#permissionselect').val(permissions).trigger('change');
    if(storedata.users == null){
      $('#select-user-type1').val('newuser').trigger('change');
    } else {
      $('#select-user-type1').val('existing').trigger('change');
    }
    // $('#select-user-type').val(roles).trigger('change');
    // $('#permissionselect').val(storedata.access_token);
    // $('#select_role').val(storedata.access_token);
  });
</script>
<script>
  $(document).ready(function() {
    $('.permissionselect').select2();
  
    $('.permissionselect').on('select2:select', function (e) {
      var value = e.params.data.id;
      if (value === 'all') {
        $('.permissionselect option:not(:selected)').prop('selected', true);
        $('.permissionselect').trigger('change');
      }
    });
  
    $('.permissionselect').on('select2:unselect', function (e) {
      var value = e.params.data.id;
      if (value === 'all') {
        $('.permissionselect option:selected').prop('selected', false);
        $('.permissionselect').trigger('change');
      }
    });
  });
</script>
@endsection