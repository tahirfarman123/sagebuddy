<div class="modal fade" id="delete-filter">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="" id="delete-form" method="post" enctype="multipart/form-data">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h4 class="modal-title">Filter Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row" class="texe-center">
                        <p>Are you Sure want to Delte Filter !</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                </div>
        </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>