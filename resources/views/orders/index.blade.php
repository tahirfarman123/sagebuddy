@extends('layouts.app')
@section('content')
<div class="">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-4 col-md-3 col-sm-12">
          <h1 class="m-0 mb-2 font-weight-bold" style="font-size: 28px;">Order</h1>
          <p class="m-0 text-mute breadc-text">Sales
            <span>/</span> Order
          </p>
        </div>
        {{-- @include('orders.floating.filter-code') --}}
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4">
          <div class="small-box card">
            <div class="inner text-center">
              <div class='d-flex justify-content-center align-item-center mb-3'>
                <i class=" fas uil uil-money-bill" style="font-size: 40px"></i>
              </div>

              <h6 style=" font-size: 14px , font-weight: 600 ">
                <span>{{ $find_Currency->symbol }}{{
                  round($total_amount)
                  }}</span>
              </h6>
              <p class='mb-0' style="font-size: 13px , color: #000 , letterSpacing: 1">Total Amount</p>

            </div>

          </div>
        </div>
        <div class=" col-lg-2 col-md-3 col-sm-4">
          <div class="small-box card">
            <div class="inner text-center">
              <div class='d-flex justify-content-center align-item-center mb-3'>
                <i class="fas uil uil-dollar-alt" style="font-size: 40px"></i>
              </div>
              <h6 style=" font-size: 14px , font-weight: 600 "><span>{{ $find_Currency->symbol }} {{
                  round($ordersTotalPricePending) }}</span>
              </h6>
              <p class='mb-0' style=" font-size: 13px , color: #000 , letterSpacing: 1">Pending Amount
              </p>

            </div>

          </div>
        </div>
        <div class=" col-lg-2 col-md-3 col-sm-4">
          <div class="small-box card">
            <div class="inner text-center">
              <div class='d-flex justify-content-center align-item-center mb-3'>
                <i class=" fas uil uil-money-withdrawal" style="font-size: 40px"></i>
              </div>
              <h6 style=" font-size: 14px , font-weight: 600 "><span> {{ $find_Currency->symbol }} {{
                  round($total_amount -
                  $ordersTotalPricePending)
                  }}</span></h6>
              <p class='mb-0' style=" font-size: 13px , color: #000 , letterSpacing: 1">Total
                Amount</p>

            </div>

          </div>
        </div>
        <div class=" col-lg-2 col-md-3 col-sm-4">
          <div class="small-box card">
            <div class="inner text-center">
              <div class='d-flex justify-content-center align-item-center mb-3'>
                <i class=" fas uil uil-box" style="font-size: 40px "></i>
              </div>
              <h6 style=" font-size: 14px , font-weight: 600"><span>{{ $totalOrders }}</span>
              </h6>
              <p class='mb-0' style=" font-size: 13px , color: #000 , letterSpacing: 1">Total
                order</p>
            </div>

          </div>
        </div>
        <div class=" col-lg-2 col-md-3 col-sm-4">
          <div class="small-box card">
            <div class="inner text-center">
              <div class='d-flex justify-content-center align-item-center mb-3'>
                <i class=" fas uil uil-bring-bottom" style="font-size: 40px"></i>
              </div>
              <h6 style=" font-size: 14px , font-weight: 600 "><span>{{ $totalLineItems
                  }}</span></h6>
              <p class='mb-0' style=" font-size: 13px , color: #000 , letterSpacing: 1">
                Total order items
              </p>

            </div>

          </div>
        </div>
        <div class=" col-lg-2 col-md-3 col-sm-4">
          <div class="small-box card">
            <div class="inner text-center">
              <div class='d-flex justify-content-center align-item-center mb-3'>
                <i class=" fas uil uil-dropbox" style="font-size: 40px "></i>
              </div>
              <h6 style=" font-size: 14px;font-weight: 600;"><span>{{
                  round($averageLineItemsPerOrder) }}</span></h6>
              <p class='mb-0' style=" font-size: 13px , color: #000 , letterSpacing: 1">AVG Item / Order</p>

            </div>

          </div>
        </div>

      </div>
      <div class=" row">

        <section class="col-lg-12 col-md-12 col-sm-12 card p-3">
          <style>
            th {
              font-size: 15px !important;
            }

            td {
              font-size: 14.5px !important;
            }
          </style>
          <table class="table" id="datatable">
            <thead>
              <tr>
                <th><input type="checkbox" id="select-all-checkbox" value="all"> #</th>
                <th>Order Name</th>
                <th>Store Name</th>
                <th>Date</th>
                <th>Status</th>
                <th>Customer</th>
                <th>Delivery Status</th>
                <th class="text-center">Payment</th>
                <th>Order Id</th>
                <th>City</th>
                <th>Total</th>
                {{-- <th>Tax</th> --}}
                {{-- <th>Location</th> --}}
                {{-- <th>Courier</th> --}}
              </tr>
            </thead>
            <tbody>
              @isset($orders)
              @foreach($orders as $key => $order)
              <tr>
                <td><input type="checkbox" class="order-id select-checkbox" data-order-id="{{ $order->table_id }}">
                  {{$key + 1}}</td>
                <td><a class="btn-link" href="{{route('shopify.order.show', $order->table_id)}}">{{$order->name}}</a>
                <td>{{$order->store->name}}</td>
                </td>
                <td>
                  @php
                  $formattedDate = \Carbon\Carbon::parse($order->created_at_date)->format('d-M-Y h:i:s A');
                  @endphp
                  {{ $formattedDate }}
                </td>
                <td>{{$order->fulfillment_status !== "" ? $order->fulfillment_status : 'Unfullfill' }}</td>
                <td>{{ $order->billing_address['first_name'] ?? '' }} {{ $order->billing_address['last_name'] ?? '' }},
                  {{$order->email}}, {{$order->phone}}</td>
                <td>
                  <span class="badge badge-light p-1">
                    {{ $order->delivery_status }}
                  </span>
                  <span class="badge">
                    {{ $order->tracking_id}}
                  </span>
                </td>
                <td class="text-center">
                  @if ($order->financial_status == 'pending')
                  <a class="btn-link" href="{{route('shopify.order.financial-status', $order->table_id)}}">
                    {{$order->financial_status }}
                  </a>
                  @else

                  {{$order->financial_status }}
                  @endif
                </td>
                <td>{{$order->id }}</td>
                <td>{{$order->shipping_address['city'] }}</td>
                <td>{{$order->total_price }}</td>
                {{-- <td>{{$order->total_tax }}</td> --}}
                {{-- <td>
                  <div class="btn-group">
                    <button type="button" class="randombtn btn btn-primary"
                      style="border-radius: 0 !important;">Location</button>
                    <button type="button" class="randombtn btn btn-primary dropdown-toggle dropdown-icon"
                      data-toggle="dropdown" aria-expanded="false" style="border-radius: 0 !important;">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sync-order">Sync Order</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Update</a>
                      <a class="dropdown-item" href="#">Canel</a>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="randombtn btn btn-primary"
                      style="border-radius: 0 !important">Courier</button>
                    <button type="button" class="randombtn btn btn-primary dropdown-toggle dropdown-icon"
                      data-toggle="dropdown" aria-expanded="false" style="border-radius: 0 !important;">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sync-order">M & P</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Update</a>
                      <a class="dropdown-item" href="#">Canel</a>
                    </div>
                  </div>
                </td> --}}
              </tr>
              @endforeach
              @endisset
            </tbody>
          </table>
        </section>
      </div>
    </div>
  </section>
</div>
{{-- Sync Order --}}
@include('orders.modals.sync-order')
@include('orders.floating.box')

@include('orders.modals.mark-fulllfillment')
@include('orders.modals.capture-payment')
@include('orders.modals.add-filter')
@include('orders.modals.export-fullfill-order')
@include('orders.modals.delete-filter')
@include('orders.modals.cancel-order')


<style>
  .border-top {
    border-top: 1px solid;
  }
</style>
<script src="{{ asset('assets/js/order-script/order.js') }}"></script>
@php $selected_store = base64_decode(request()->cookie('selected_sto')); @endphp
@include('layouts.datatable')
<script>
  $(function () {
  var filterButtons = [
    {
      text: 'All',
      className: '',
      action: function (e, dt, button, config) {
        window.location = "{{ route('shopify.orders.filter') }}";
      }
    }
  ];

    @foreach ($filters as $filter)
        filterButtons.push({
            text: '{{ $filter->name }}',
            className: '',
            action: function (e, dt, button, config) {
              window.location = "{{ route('shopify.orders.filter', ['filter'=> $filter->id]) }}";
            }
        });
    @endforeach
    const obj = {
      text: 'Add New',
      className: 'btn btn-primary border-top',
      action: function (e, dt, button, config) {
        $('#add-filter').modal('show');
      }
    };
    var arrlen = filterButtons.length;
    filterButtons.splice(arrlen, 0 , obj);
  $("#datatable").DataTable({
      scrollX: true, "lengthChange": true, "autoWidth": true,
      "processing": true,
        "language": {
            processing: '<i class="uil uil-spinner"></i><span class="sr-only">Loading...</span> '},
      deferLoading: 20, 
    "buttons": [ 
          {
            text: '<i class="uil uil-filter"></i> View',
            className: 'btn btn-prmairy',
            extend: 'collection',
            autoClose: true,
            buttons: filterButtons
        },
        {
              text: 'Export To Excel',
              className: 'btn btn-primary fulfill_submit',
              action: function (e, dt, button, config) {
                e.preventDefault();
                var data = {};
                data['order_number'] = selectedOrderIds1;
                $.ajax({
                    type: 'GET',
                    url: "{{route('shopify.order.exportto')}}",
                    data: data,
                    xhrFields:{
                      responseType: 'blob'
                    },
                    success: function (data) {
                        console.log(window.webkitURL);
                        var url = window.URL || window.webkitURL;
                        var objectUrl = url.createObjectURL(data);
                        window.open(objectUrl);
                    }
                });
              }
          },
          {
        text: 'Bulk Action',
        className: 'btn btn-prmairy',
        extend: 'collection',
        autoClose: true,
        buttons: [
          @canany(['all-access','sync-order'])
          {
            text: 'Sync Order',
            className: '',
            action: function (e, dt, button, config) {
              $('#sync-order').modal('show');
              $('#bookorder').val('sync_order');
            }
          },
        @endcanany
        {
            text: 'Sync MnP Order',
            className: '',
            action: function (e, dt, button, config) {
              $('#sync-order').modal('show');
              $('#bookorder').val('book_mnp_order');
            }
          },
          {
            text: 'Import Order From Excel',
            className: '',
            action: function (e, dt, button, config) {
              window.location = "{{ route('shopify.import') }}";
            }
          },
          {
            text: 'Export for Fullfill',
            className: '',
            action: function (e, dt, button, config) {
              $('#book-fullfill-order').modal('show');
            }
          }
        ]
    },    
    "copy", "csv", "excel", "pdf", "print", "colvis"],
    "columnDefs": [
    { "orderable": false, "targets": 0 }
    ]
  }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
});
</script>

@endsection