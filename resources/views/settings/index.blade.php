@extends('layouts.app')
@section('content')
<div class="">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-lg-4 col-md-3 col-sm-12">
          <h1 class="m-0 mb-2 font-weight-bold" style="font-size: 28px;">Settings</h1>
          <p class="m-0 text-mute breadc-text">Setting
            <span>/</span>
          </p>
        </div>
        {{-- --}}
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 ">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                @canany(['write-setting'])
                <li class="nav-item">
                  <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill"
                    href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home"
                    aria-selected="true">Store Setting</a>
                </li>
                @endcanany


                {{-- @canany(['all-access', 'write-setting'])
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill"
                    href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile"
                    aria-selected="false">Currency</a>
                </li>
                @endcanany --}}

                @canany(['all-access'])
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill"
                    href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile"
                    aria-selected="false">Currency</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" id="role-permission-tab" data-toggle="pill" href="#role-permission" role="tab"
                    aria-controls="role-permission" aria-selected="false">Role & Permission</a>
                </li>
                @endcanany
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-above-settings-tab" data-toggle="pill"
                    href="#custom-content-above-settings" role="tab" aria-controls="custom-content-above-settings"
                    aria-selected="false">Courier Management</a>
                </li>
              </ul>
              <div class="tab-content" id="custom-content-above-tabContent">
                <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel"
                  aria-labelledby="custom-content-above-home-tab">
                  @livewire('setting.store-setting')
                </div>
                <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel"
                  aria-labelledby="custom-content-above-profile-tab">

                  @canany(['all-access'])
                  @livewire('setting.currency-manager')
                  @endcanany
                </div>
                <div class="tab-pane fade" id="role-permission" role="tabpanel" aria-labelledby="role-permission-tab">
                  {{-- <livewire:role-and-permission> --}}
                    @livewire('setting.role-and-permission')
                </div>
                <div class="tab-pane fade" id="custom-content-above-settings" role="tabpanel"
                  aria-labelledby="custom-content-above-settings-tab">
                  @livewire('setting.courier-management')
                  @include('settings.courier-management.modal')
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="sync-order">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{route('orders.sync')}}">
        <div class="modal-header">
          <h4 class="modal-title">Import Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @livewire('settings')
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-primary">Sync Order</button>
        </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@include('layouts.datatable')
<script>
  $("#datatable").DataTable();
</script>
@endsection