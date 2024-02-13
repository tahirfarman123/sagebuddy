@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 mb-2 font-weight-bold">Dashboard</h1>
        <p class="m-0 text-mute">Dashboard</p>
      </div>
      <div class="col-sm-6">

      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box card">
          <div class="inner">
            <h3>{{$stores_count ?? 0}}</h3>

            <p>Stores</p>
          </div>

        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box card">
          <div class="inner">
            <h3>{{$private_stores ?? 0}}</h3>

            <p>Private Stores</p>
          </div>

        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box card">
          <div class="inner">
            <h3>{{$public_stores ?? 0}}</h3>

            <p>Public Stores</p>
          </div>

        </div>
      </div>
    </div>

</section>
@endsection