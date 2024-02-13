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
          <button class="btn btn-primary" data-toggle="modal" data-target="#add-store">
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
          @canany(['write-setting'])
          <div class="btn-group" style="float: right; margin-right: 10px; margin-top: 10px">
            <button type="button" style="background: transparent; border: none;" class="dropdown-toggle dropdown-icon"
              data-toggle="dropdown" aria-expanded="false">
              <span class=""><i class="uil uil-ellipsis-v"></i></span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
              <a class="dropdown-item store-e" href="#" data-store="{{ $store }}" data-toggle="modal"
                data-target="#edit-store">Update</a>
              {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sync-order">Edit</a> --}}
              <a class="dropdown-item delete-store" href="" data-filter="{{ $store->table_id }}" data-toggle="modal"
                data-target="#delete-store">Delete</a>
              <a class="dropdown-item" href="#">Cancel</a>
            </div>
          </div>
          @endcanany
          <div class="text-center inner" style=" text-align: center , padding: 5px">
            <a href="{{ route('shopify.store.order', $store->name) }}" style="color: #000;">
              <div class='mb-3 logo-div'>
                {{-- <i class=" fas uil uil-store" style="font-size: 40px"></i> --}}
                @if ($store->image == null)
                <img src="{{ asset('dist/img/icon.png') }}" width="70px" alt="">
                @else
                <img src="{{ asset('')}}{{$store->image}}" alt="" width="70px">
                @endif
              </div>
              <h6 style=" font-size: 14px , font-weight: 600 ">{{$store->name}}</span></h6>
            </a>
          </div>

        </div>
      </div>
      @endforeach
    </div>
  </section>
</div>

<div class="modal fade" id="add-store">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{route('admin.stores.store')}}" id="store-form" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Add Store</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class='row'>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="url">Shopify Store Url</Label>
                <Input tabIndex="3" type="text" id="myshopify_domain" class="form-control Input Input"
                  name="myshopify_domain" placeholder='example.shopify.com' value="" />
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_key">API Key</Label>
                <Input tabIndex="4" type="text" class="form-control Input Input" name="api_key" placeholder='API Key'
                  value="">
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_secret_key">API Secret Key</Label>
                <Input tabIndex="5" type="text" class="form-control Input Input" name="api_secret_key"
                  placeholder='Api Secret Key' value="">
              </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Access Token</Label>
                <Input tabIndex="6" type="text" class="form-control Input Input" name="access_token"
                  placeholder='Access Token' value="">
              </div>
            </div>
            <style>
              .select2-selection--single {
                height: 42px !important;

              }
            </style>
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
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="access_token">Store Image</Label>
                <Input tabIndex="6" type="file" class="form-control Input Input" name="image">
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
<div class="modal fade" id="edit-store">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{route('admin.stores.update')}}" id="store-form" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="hidden" name="store_id" id="store_id">
        <div class="modal-header">
          <h4 class="modal-title">Update Store</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class='row'>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="url">Shopify Store Url</Label>
                <Input tabIndex="3" type="text" class="form-control Input" name="myshopify_domain"
                  placeholder='example.shopify.com' id="myshopify_domain" value="" />
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="api_key">API Key</Label>
                <Input tabIndex="4" type="text" class="form-control Input" name="api_key" placeholder='API Key'
                  id="api_key" value="">
              </div>

            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
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
            </div>
            <div class='col-lg-6 col-md-6 col-sm-12'>
              <div>
                <Label for="currency_id">Store Currency</Label>
                <select name="currency_id" class="select2 form-control" style="width: 100% " id="">
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
                <Label for="access_token">Store Image</Label>
                <Input tabIndex="6" type="file" class="form-control Input" name="image" id="image">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="submit" class="btn btn-primary">Update</button>
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
  $('.store-e').on('click', function(){
    $('form').attr('action', '{{ route('admin.stores.update')}}');
    var storedata = $(this).data('store');
    // alert(storedata);
    $('#store_id').val(storedata.table_id);
    $('#myshopify_domain').val(storedata.myshopify_domain);
    $('#api_key').val(storedata.api_key);
    $('#api_secret_key').val(storedata.api_secret_key);
    $('#access_token').val(storedata.access_token);
  });
  $('.delete-store').on('click', function(){
    var filterdata = $(this).data('filter');
    const url = "{{ route('admin.stores.destroy', ['id' => ':id']) }}";
    $('#delete-form').attr('action', url.replace(':id', filterdata));
  });
</script>
@endsection