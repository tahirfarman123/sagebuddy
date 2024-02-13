<div class="modal fade" id="sync-order">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('orders.sync')}}">
                <div class="modal-header">
                    <h4 class="modal-title">Sync Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <label class="lable-f">Select Store</label>
                    <div class="select2-purple">
                        @php $selected_store = base64_decode(request()->cookie('selected_sto')); @endphp
                        <select class="select2" multiple="multiple" name="select_store[]"
                            data-dropdown-css-class="select2-purple" data-placeholder="Select a State"
                            style="width: 100%;">
                            @if (auth()->user()->roles[0]->name !== 'SubUser')
                            <option value="all">All</option>
                            @endif
                            @foreach ($stores as $store)
                            <option value="{{ $store->table_id }}" @if ($selected_store==$store->name) selected
                                @endif>{{
                                $store->name
                                }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="sync_book_order" id="bookorder">
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