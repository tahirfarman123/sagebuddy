{{-- <div class="col-lg-8 col-md-9 col-sm-12 justify-content-end align-self-center gap-11 d-flex flex-row flex-sm-row
"> --}}

          {{-- <button class="randombtn" onclick="showOrderFilter()">
            <i class="uil uil-filter"></i>
          </button> --}}
          {{-- <button class="randombtn">
            <i class="uil uil-filter"></i>
          </button> --}}
          {{--<div class="OrderFilter" id="OrderFilter" style="display: none;">
            <button type="button" class="close" onclick="showOrderFilter()">
              <span aria-hidden="true">&times;</span>
            </button>
            <form action="{{ route('shopify.orders.filter') }}" method="get">
              <div class="input-box">
                <label for="" class="form-label lable-f">ID</label>
                <input type="text" class="form-control Input" name="order_id" style="" id=""
                  placeholder="Scan or Enter Seprated Order Id">
              </div> --}}
              {{-- <div class="input-box">
                <label for="" class="form-label lable-f">External Order Number</label>
                <input type="text" class="form-control Input" name="" style="" id=""
                  placeholder="Scan or Enter External Order Number">
              </div> --}}
              {{-- <div class="input-box">
                <label for="" class="form-label lable-f">Tracking Id</label>
                <input type="text" class="form-control Input" name="" style="" id=""
                  placeholder="Scan or Enter Tracking Id">
              </div> --}}
              {{-- <div class="input-box">
                <label for="" class="form-label lable-f">Amount</label>
                <div class="d-flex gap-11">
                  <input type="number" class="form-control Input" name="min_amount" min="1" style="" id=""
                    placeholder="Min">
                  <input type="number" class="form-control Input" name="max_amount" min="1" style="" id=""
                    placeholder="Max">
                </div>
              </div> --}}
              {{-- <div class="input-box">
                <label for="" class="form-label lable-f">Select Store</label>
                <select class="form-control Input" name="select_store" id="">
                  <option value="">Select Store</option>
                  @foreach ($stores as $store)
                  <option value="{{ $store->table_id }}" @if ($store_id==$store->table_id) selected @endif>{{
                    $store->name
                    }}</option>
                  @endforeach
                </select>
              </div> --}}
              {{-- <div class="input-box">
                <label for="" class="form-label lable-f">Product</label>
                <input type="text" class="form-control Input" name="" style="" id="" placeholder="Product ">
              </div> --}}
              {{-- <div class="input-box">
                <label for="" class="form-label lable-f">Brand</label>
                <input type="text" class="form-control Input" name="" style="" id="" placeholder="Brand ">
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class='btn btn-primary mr-2'>
                  Filter
                </button>
                <button type="button" class='btn btn-outline-primary'>
                  Reset
                </button>
              </div>
            </form>
          </div>--}}
          {{-- <button class='btn btn-primary randombtn'>
            <div class='d-flex gap-2 p-1'>
              <i class="uil uil-plus"></i>
              <span class='mb-0'>New Order</span>
            </div>
          </button> --}}
          {{-- <button class='btn btn-primary randombtn' data-toggle="modal" data-target="#add-filter">
            <i class="uil uil-plus"></i>
            New View
          </button> --}}
          {{-- <div class="btn-group">
            <button type="button" class="btn btn-primary"><i class="uil uil-filter"></i> View</button>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown"
              aria-expanded="false">
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu" style="float: left;">
              <a class="dropdown-item" href="{{ route('shopify.orders')}}">All</a>

              @foreach ($filters as $filter)
              <div class="d-flex justify-content-between">
                <a class="dropdown-item" href="{{ route('shopify.orders.filter', ['filter'=> $filter->id]) }}">{{
                  $filter->name
                  }}</a>
                <div class="d-flex" style="margin-top: 6px;">
                  <a class="filter-e" href="" data-filter="{{ $filter }}" data-toggle="modal"
                    data-target="#add-filter"><i class="uil uil-edit"></i> </a>
                  <a class="filter-delete" data-filter="{{ $filter->id }}" style="color: red !important;" href=""
                    data-toggle="modal" data-target="#delete-filter"><i class="uil uil-trash"></i> </a>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <button class="btn btn-primary fulfill_submit">Export to Excel</button>
          <div class="btn-group">
            <button type="button" class="btn btn-primary">More</button>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown"
              aria-expanded="false">
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sync-order">Sync Order</a>
              <a class="dropdown-item" href="{{ route('shopify.import') }}">Import Order From Excel</a>
            </div>
          </div> --}}

          {{--
        </div> --}}