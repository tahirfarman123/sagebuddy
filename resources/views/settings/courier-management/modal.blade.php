<div wire:ignore class="modal fade" id="courier">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form method='post' action="{{ route('couriers.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Add Courier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Name</Label>
                            <input type="text" class="form-control Input" name='name'
                                placeholder="Enter couriers service name" value="" id="">
                        </div>
                        <div class="col-md-12">
                            <label>Logo</Label>
                            <input type="file" class="form-control Input" name='image' accept="png/jpg">
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