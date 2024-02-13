@extends('layouts.app')
@section('content')
<div class="">
  <a class="randombtn" href="{{ route('shopify.orders') }}"><i class="uil uil-arrow-left"></i> back</a>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-4 col-md-3 col-sm-12">
          <h1 class="m-0 mb-2 font-weight-bold" style="font-size: 28px;">Import FullFill Order</h1>
          <p class="m-0 text-mute breadc-text">FullFill
            <span>/</span> <a href="{{ route('shopify.orders') }}">Order</a>
          </p>
        </div>
        {{-- <div
          class="col-lg-8 col-md-9 col-sm-12 justify-content-end align-self-center gap-11 d-flex flex-row flex-sm-row">
          <button class="btn btn-primary" data-toggle="modal" data-target="#import-order">
            Import Order
          </button>

        </div> --}}
      </div>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p> -->
              <div class="d-flex justify-content-between mt-2">
                <div>
                  <input type="text" class="form-control" name="shipping_company" id="shipping_company" value="Others">
                </div>
                <div class="d-flex">
                </div>
              </div>
              <div class="overlay" style="display: none; position: absolute; left: 45%">
                <img src="{{ asset('dist/img/sf.gif')}}" width="80px" alt="">
              </div>

              <!-- Table with stripped rows -->
              <table class="table" id="datatable">
                <thead>
                  <tr>
                    <th scope="col"># <input type="checkbox" id="select-all-checkbox" value="all"></th>
                    <th scope="col">Order Name</th>
                    <th scope="col">Tracking Id</th>
                    <th scope="col">Tracking Url</th>
                    <th scope="col">Created Date</th>
                  </tr>
                </thead>
                <tbody>
                  @isset($orders)
                  @foreach($orders as $key => $order)
                  <tr>
                    <td>{{$key + 1}} <input type="checkbox" class="order-id select-checkbox"
                        data-order-id="{{ $order->Barcode }}">
                    </td>
                    <td>{{$order->barcode}}</td>
                    <td>{{$order->trackingid}}</td>
                    <td>{{$order->tracking_url}}</td>
                    <td>{{date('Y-m-d h:i:s', strtotime($order->created_at))}}</td>
                  </tr>
                  @endforeach
                  @endisset
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="import-order">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form action="{{ route('import.fullfill') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Import Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <br>
          <div class="d-flex">
            <input type="file" class="form-control" name="import">
          </div>
          <br>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="submit" class="btn btn-primary submit-action"><span class="text-hide1">Submit</span>
            <div style="display: none;" class="loader-s">

            </div>
          </button>
        </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

@include('layouts.datatable')

<script>
  var selectedOrderIds1  = [];
  $('.select-checkbox').on('click', function(){
    var checkbox = $(this);
    var orderId = checkbox.data('order-id');
    
    if (checkbox.prop('checked')) {
            selectedOrderIds1.push(orderId);
            console.log(selectedOrderIds1);
    } else {
        // Checkbox is unchecked, remove from the array if it exists
        var index = selectedOrderIds1.indexOf(orderId);
        if (index !== -1) {
            selectedOrderIds1.splice(index, 1);
            console.log(selectedOrderIds1);
        }
    }
    
    $('#selectedOrderIds').val(selectedOrderIds1.join(','));
  });
  document.getElementById('select-all-checkbox').addEventListener('change', function() {
    const isChecked = this.checked;
    selectedOrderIds1 = [];

    document.querySelectorAll('.select-checkbox').forEach(checkbox => {
        checkbox.checked = isChecked;
        if (isChecked) {
            var orderId = checkbox.getAttribute('data-order-id');
            selectedOrderIds1.push(orderId);
        }
    });

    // Check if the array is not empty when checkboxes are checked
    if (isChecked && selectedOrderIds1.length === 0) {
        // Handle the case where no checkboxes are selected after checking all
        alert('Please select at least one checkbox.');
        // Optionally, you may want to uncheck the "select-all-checkbox" here
        this.checked = false;
    }

    console.log(selectedOrderIds1);
  });

  $('.submit-action').on('click', function(){
    $('.loader-s').show();
    $('.text-hide1').hide();

  })
  @php
    $user = auth()->user();
    if (auth()->user()->roles[0]->name == 'SubUser'){
    $store_spil = explode(",", $user->store_id);

    $stores1 = \App\Models\Store::whereIn('table_id', $store_spil)->get();
    } else {
    $stores1 = \App\Models\Store::where('user_id', $user->id)->get();
    }
    $selected_store = base64_decode(request()->cookie('selected_sto'));
  @endphp
  var filterButtons = [];
  @foreach ($stores1 as $store)
    filterButtons.push({
            text: '{{ $store->name }}',
            className: '',
            action: function (e, dt, button, config) {
              changeStore('{{$store->name}}');
            }
        });
    @endforeach
 
  $("#datatable").DataTable({
       "lengthChange": true, "autoWidth": true,
      "processing": true,
        "language": {
            processing: '<i class="uil uil-spinner"></i><span class="sr-only">Loading...</span> '},
        "buttons": [ 
          {
            text: 'Import Fullfill Order',
            className: 'btn btn-primary',
            action: function (e, dt, button, config) {
             $('#import-order').modal('show');
            }
          },
          {
            text: '{{ in_array($selected_store, $stores1->pluck('name')->toArray()) ? $selected_store : 'Select Store' }}',
            className: 'btn btn-prmairy',
            extend: 'collection',
            autoClose: true,
            buttons: filterButtons
        }, 
        {
          text: 'Fullfill',
          className: 'btn btn-primary fulfill_submit',
          action: function (e, dt, button, config) {
            e.preventDefault();
            // document.getElementById('preloader').style = "height: 100%; background: #0000008f";
            // document.getElementById('preloader-img').style = "display: block";
            var data = {};
            data['order_number'] = selectedOrderIds1;
            data['shipping_company'] = $('#shipping_company').val();
            $.ajax({
                type: 'POST',
                url: "{{route('shopify.order.fulfill')}}",
                data: data,
                // async: false,
                success: function (response) {
                    window.top.location.reload();

                }
            });
          }
        },
        {
              text: 'Clear',
              className: 'btn btn-primary',
              action: function (e, dt, button, config) {
                e.preventDefault();
                document.getElementById('preloader').style = "height: 100%; background: #0000008f";
                document.getElementById('preloader-img').style = "display: block";
                var data = {};
                data['order_number'] = selectedOrderIds1;
                $.ajax({
                    type: 'POST',
                    url: "{{route('shopify.fullfill.clear')}}",
                    data: data,
                    // async: false,
                    success: function (response) {
                        window.top.location.reload();
                    }
                });
              }
          }
        ],
    "columnDefs": [
    { "orderable": false, "targets": 0 }
    ]
  }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
</script>
@endsection