@extends('layouts.app')
@section('content')
<div class="">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-4 col-md-3 col-sm-12">
          <h1 class="m-0 mb-2 font-weight-bold" style="font-size: 28px;">Products</h1>
          <a href="{{ route('shopify.orders') }}">Home</a><span> /</span>
          <span class="m-0 text-mute breadc-text">FullFill
          </span>
        </div>
        <div
          class="col-lg-8 col-md-9 col-sm-12 justify-content-end align-self-center gap-11 d-flex flex-row flex-sm-row">
          @can('write-products')
          <a href="{{route('shopify.products.sync')}}" style="float: right" class="btn btn-primary">Sync
            Products</a>
          <a href="{{route('shopify.product.create')}}" style="float:right" class="btn btn-secondary">Create
            Product</a>
        </div>
        @endcan

      </div>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @isset($products)
                  @if($products !== null)
                  @foreach($products as $key => $product)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$product['title']}}</td>
                    <td>{{$product['product_type']}}</td>
                    <td>{{$product['vendor']}}</td>
                    <td>{{date('Y-m-d', strtotime($product['created_at']))}}</td>
                    <td><a href="{{route('change.product.addToCart')}}?product_id={{$product['table_id']}}"
                        class="btn btn-primary">{{$product->getAddToCartStatus()['message']}}</a></td>
                  </tr>
                  @endforeach
                  @endif
                  @endisset
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection