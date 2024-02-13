@extends('layouts.app')
@section('content')
<div class="">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-4 col-md-3 col-sm-12">
                    <h1 class="m-0 mb-2 font-weight-bold" style="font-size: 28px;">User</h1>
                    <p class="m-0 text-mute breadc-text">Profile
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
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">

                                    <div class="box box-primary">
                                        <div class="box-body box-profile">
                                            {{-- <img class="profile-user-img img-responsive img-circle"
                                                src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> --}}
                                            <h3 class="profile-username text-center">{{ $user->name }}</h3>
                                            <p class="text-muted text-center"></p>
                                        </div>

                                    </div>


                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">About Me</h3>
                                        </div>

                                        <div class="box-body">
                                            <strong><i class="fa fa-book margin-r-5"></i> Email</strong>
                                            <p class="text-muted">
                                                {{ $user->email}}
                                            </p>
                                            <hr>
                                            <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                                            <p class="text-muted">Malibu, California</p>
                                            <hr>
                                            <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum
                                                enim neque.</p>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-9">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li><a href="#settings" data-toggle="tab">Settings</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="settings">
                                                <form action="{{ route('update.profile') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                    <div class="form-group">
                                                        <label for="inputName"
                                                            class="col-sm-2 control-label">Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="name"
                                                                id="inputName" placeholder="Name"
                                                                value="{{ $user->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail"
                                                            class="col-sm-2 control-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" id="inputEmail"
                                                                placeholder="Email" name="email"
                                                                value="{{ $user->email }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputName"
                                                            class="col-sm-2 control-label">Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" name="password" class="form-control"
                                                                id="password" placeholder="******" value="">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <Label for="currency_id">Currency</Label>
                                                        <select name="currency_id" class="select2 form-control Input"
                                                            style="width: 100% " id="">
                                                            <option value="">Select Currency</option>
                                                            @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->id }}" @if($user->currency_id
                                                                == $currency->id) selected @endif>{{ $currency->name }}
                                                                -
                                                                {{ $currency->code }} - {{
                                                                $currency->symbol }}</option>
                                                            @endforeach
                                                            <option value=""></option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit"
                                                                class="btn btn-success">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>

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