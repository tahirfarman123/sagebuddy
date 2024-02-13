<div class="modal fade" id="cancel-order">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ route('order.cancel')}}" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Order Cancel/Void</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <p>Are you Sure to Cancel/Void Order!</p>
                    <input type="hidden" name="orderids" class="orderids">
                    <input type="hidden" name="changeRequestType" id="changeRequestType">
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
        </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>