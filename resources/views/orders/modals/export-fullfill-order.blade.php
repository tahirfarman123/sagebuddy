<div class="modal fade" id="book-fullfill-order">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('order.book.fullfill') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Book for Fullfillment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Service Type</label>
                            <select name="service" class="form-select form-control" id="">
                                <option value="">Select Service Type</option>
                                <option value="Overnight">Overnight</option>
                                <option value="Second Day">Second Day</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="">Special Handling</label>
                            <select name="fragile" class="form-select form-control" id="">
                                <option value="">Special Handling</option>
                                <option value="yes">Yes </option>
                                <option value="no">no</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="">Remarks</label>
                            <textarea name="remarks" class="form-control"></textarea>
                            <input type="hidden" name="bookIds" id="bookIds">
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