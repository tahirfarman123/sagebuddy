<div class="">

    <div class="row">
        <div class="col-md-6 card p-3">
            <h4>Store Currency</h4>
            <form wire:submit='update'>
                <div class="d-flex">
                    <select wire:model.defer='currency_id' class="form-control Input" style="width: 100% " id="">
                        @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}" {{ $user->currency_id == $currency->id ? 'selected' : ''
                            }}>{{
                            $currency->name }} - {{ $currency->code }} - {{
                            $currency->symbol }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-primary ml-1" type='submit'>Update</button>
                </div>

            </form>
        </div>
    </div>
</div>