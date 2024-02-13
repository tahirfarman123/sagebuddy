<div class="">
    <h4>Courier Manage</h4>
    <button class="btn btn-outline-primary ml-1" data-toggle="modal" data-target="#courier">Add New</button>
    <div class="row">
        @foreach ($couriers as $courier)
        <div class="col-md-6 card p-3">

            <form wire:submit.prevent="saveCourier('{{ $courier->table_id }}')">
                <div>
                    <div>
                        <img src="{{ asset('')}}{{ $courier->image }}" width="70px" class="img-thumbnail" alt="">
                        <label>{{$courier->name}}</label>
                    </div>
                    {{-- @if ($courier->courierSettings->isNotEmpty())

                    @else

                    @endif --}}

                    @foreach ($courier->courierIndex as $index => $courierIndex)
                    <label>{{ $courierIndex->name }}</label>
                    <input type="text" class="form-control Input"
                        wire:model.defer="couriers.{{ $courier->table_id }}.{{ $index }}"
                        placeholder="Enter couriers service {{ $courierIndex->name }}"
                        id="courier_{{ $courier->table_id }}_{{ $index }}" value="{{ $courierIndex->value ?? '' }}">
                    @endforeach

                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
        @endforeach
    </div>
    <div wire:ignore class="modal fade" id="courier">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent='save' enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Add Courier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name</Label>
                                <input type="text" class="form-control Input" wire:model.defer='name'
                                    placeholder="Enter couriers service name" value="" id="">
                            </div>
                            <div class="col-md-6">
                                <label>Logo</Label>
                                <input type="file" class="form-control Input" wire:model.defer='image' accept="png/jpg">
                            </div>
                            <div class="col-md-6">
                                <label>Key Name 1</Label>
                                <input type="text" class="form-control Input" wire:model.defer='key1'
                                    placeholder="Enter Value" value="" id="">
                            </div>

                            <div class="col-md-6">
                                <label>Key Name 2</Label>
                                <input type="text" class="form-control Input" wire:model.defer='key2'
                                    placeholder="Enter Value" value="" id="">
                            </div>

                            <div class="col-md-6">
                                <label>Key Name 3</Label>
                                <input type="text" class="form-control Input" wire:model.defer='key3'
                                    placeholder="Enter Value" value="" id="">
                            </div>

                            <div class="col-md-6">
                                <label>Key Name 4</Label>
                                <input type="text" class="form-control Input" wire:model.defer='key4'
                                    placeholder="Enter Value" value="" id="">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@script
<script>
    $wire.on('close-modal', () => {
        $('#courier').modal('hide');
    });
</script>
@endscript