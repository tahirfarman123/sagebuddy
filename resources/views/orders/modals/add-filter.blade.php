<div class="modal fade" id="add-filter">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('filters.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Filter</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="filter_id" id="filter_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-box">
                                <label class="lable-f">Name</label>
                                <input type="text" tabindex="1" id="name" class="form-control Input" name="name"
                                    value="" placeholder="FIlter Name">
                            </div>
                            {{-- <div class="input-box">
                                <label for="" class="form-label lable-f">External Order Number</label>
                                <input type="text" tabindex="3" id="order_number" class="form-control Input"
                                    name="order_number" placeholder="Scan or Enter External Order Number">
                            </div> --}}

                            <div class="input-box">
                                <label for="" class="form-label lable-f">Date Range</label>
                                {{-- <input type="text" tabindex="8" class="form-control Input" name="date_range"
                                    style="" id="date_range" placeholder="Brand "> --}}
                                <select name="date_range" class="form-control Input" id="date_range">
                                    <option value="all">All</option>
                                    <option value="toay">Today</option>
                                    <option value="week">Past Week</option>
                                    <option value="nextweek">Next Week</option>
                                    <option value="month">1 Month</option>
                                    <option value="6month">6 Month</option>
                                    <option value="1year">1 Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            {{-- <div class="input-box">
                                <label for="" class="form-label lable-f">ID</label>
                                <input type="text" tabindex="2" class="form-control Input" name="id" style="" id="id"
                                    placeholder="Scan or Enter Seprated Order Id">
                            </div> --}}
                            {{-- <div class="input-box">
                                <label for="" class="form-label lable-f">Tracking Id</label>
                                <input type="text" tabindex="4" class="form-control Input" name="tracking_id" style=""
                                    id="tracking_id" placeholder="Scan or Enter Tracking Id">
                            </div> --}}
                            {{-- <div class="input-box">
                                <label for="" class="form-label lable-f">Amount</label>
                                <div class="d-flex gap-11">
                                    <input type="number" tabindex="6" class="form-control Input" name="min_amount"
                                        min="1" style="" id="min_amount" placeholder="Min">
                                    <input type="number" tabindex="7" class="form-control Input" name="max_amount"
                                        min="1" style="" id="max_amount" placeholder="Max">
                                </div>
                            </div> --}}
                            {{-- <div class="input-box">
                                <label for="" class="form-label lable-f">Product</label>
                                <select class="form-control Input" tabindex="9" id="product_id" name="product_id">
                                    <option value="all">All</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="input-box">
                                <label for="" class="form-label lable-f">Fulfillment Status</label>
                                <select class="form-control Input" tabindex="9" id="fullfillment" name="fullfillment">
                                    <option value="all">All</option>
                                    <option value="fulfilled">Fullfill</option>
                                    <option value="unfulfilled">Unfulfilled</option>
                                    <option value="partial">Partial</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-box">
                        <label class="lable-f">Select Store</label>
                        <div class="select2-purple">
                            <select class="select2" tabindex="5" id="select_store" multiple="multiple"
                                name="select_store[]" data-dropdown-css-class="select2-purple"
                                data-placeholder="Select a State" style="width: 100%;">
                                @if (auth()->user()->roles[0]->name !== 'SubUser')
                                <option value="all">All</option>
                                @endif
                                @foreach ($stores as $store)
                                <option value="{{ $store->name }}" @if ($store_id==$store->table_id) selected @endif>{{
                                    $store->name
                                    }}</option>
                                @endforeach
                            </select>
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