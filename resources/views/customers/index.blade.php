@extends('layouts.app')
@section('css')
{{--
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
{{--
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endsection
@section('content')

<div class="pagetitle">
  <div class="row">
    <div class="col-8">
      <h1>Customers</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
          <li class="breadcrumb-item">Customers</li>
        </ol>
      </nav>
    </div>
    <div class="col-4">
      @can('write-customers')
      <a href="" style="float: right" class="btn btn-primary" data-toggle="modal" data-target="#sync-customer">Sync
        Customers</a>
      @endcan
    </div>
  </div>
</div><!-- End Page Title -->
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">

          <!-- Table with stripped rows -->
          <table class="table" id="datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created On</th>
              </tr>
            </thead>
            <tbody>
              @foreach ( $customers as $customer)
              <tr>
                <td> {{ $customer->id }}</td>
                <td> {{ $customer->first_name }} {{ $customer->last_name }}</td>
                <td> {{ $customer->email }}</td>
                <td> {{ $customer->phone }}</td>
                <td> {{ $customer->default_address }}</td>
                <td> {{ $customer->created_at }}</td>
              </tr>
              @endforeach

            </tbody>
          </table>
          <!-- End Table with stripped rows -->
        </div>
      </div>

    </div>
  </div>
</section>
<div class="modal fade" id="sync-customer">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{route('customers.sync')}}">
        <div class="modal-header">
          <h4 class="modal-title">Import Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <label class="lable-f">Select Store</label>
          <div class="select2-purple">
            <select class="select2" multiple="multiple" name="select_store[]" data-dropdown-css-class="select2-purple"
              data-placeholder="Select a State" style="width: 100%;">
              @if (auth()->user()->roles[0]->name !== 'SubUser')
              <option value="all">All</option>
              @endif
              @foreach ($stores as $store)
              <option value="{{ $store->table_id }}">{{
                $store->name
                }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="submit" class="btn btn-primary">Sync Csutomer</button>
        </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@endsection

@section('scripts')

{{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}

<script>
  $('#dt-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{route('customers.list')}}',
    columns: [
      {data: '#', name: '#'},
      {data: 'first_name', name: 'first_name'},
      {data: 'email', name: 'email'},
      {data: 'phone', name: 'phone'},
      {data: 'created_at', name: 'created_at'}
    ]
  });
</script>
@endsection