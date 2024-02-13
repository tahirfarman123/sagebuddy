<div class="modal fade" id="capture-payment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('shopify.order.bulk.payment') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Capture all order payments</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>This will capture payments for all selected orders.</p>
                    <input type="hidden" name="captureIds" id="captureIds">
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