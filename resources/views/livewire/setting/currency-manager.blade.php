<div class="row">
    {{-- @foreach ($currencies as $index => $currency)
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4 pt-2">
                <input type="text" class="form-control" value="{{ $currency['name'] }}"
                    wire:model.defer="currencies.{{ $index }}.name" name="currency_name">
                @error("currencies.{$index}.name")
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-4 pt-2">
                <input type="text" class="form-control" value="{{ $currency['symbol'] }}"
                    wire:model.defer="currencies.{{ $index }}.symbol" name="currency_symbol">
                @error("currencies.{$index}.symbol")
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-2 pt-2 d-flex">
                <button wire:click="updateCurrency({{ $currency['id'] }}, {{ $index }})" class="btn"
                    style="color: var(--color); border: 1px solid var(--color);"><i class="uil uil-edit"></i></button>
                <button wire:click="deleteCurrency({{ $currency['id'] }})" style="color: red; border: 1px solid red;"
                    class="btn ml-1"><i class="uil uil-trash"></i></button>
            </div>
        </div>
    </div>
    @endforeach --}}
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3 pt-2">
                <input type="text" class="form-control" value="" placeholder="Enter Currency name" name="currency_name"
                    wire:model.defer="newCurrencyName" required>
                @error('newCurrencyName')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-3 pt-2">
                <input type="text" class="form-control" value="" placeholder="Enter Currency Code" name="currency_code"
                    wire:model.defer="newCodeName" required>
                @error('newCodeName')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-3 pt-2">
                <input type="text" class="form-control" value="" placeholder="Enter Currency Symbol"
                    name="currency_symbol" wire:model.defer="newSymbolName" required>
                @error('newSymbolName')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-3 pt-2">
                <button wire:click="saveCurrency" class="btn"
                    style="color: var(--color); border: 1px solid var(--color);"><i class=" uil uil-plus"></i></button>
            </div>
        </div>
    </div>
    <style>
        #datatable_wrapper {
            margin-top: 10px;
            width: 100%;
        }
    </style>

    <table class="table" id="datatable" style="width: 100%">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all-checkbox" value="all"> #</th>
                <th>Name</th>
                <th>Code</th>
                <th>Symbols</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @isset($currencies)
            @foreach($currencies as $key => $currency)
            <tr>
                <td>{{$key + 1}}</td>
                <td> @if ($editIndex === $key)
                    <input type="text" wire:model.defer="currencies.{{ $key }}.name" class="form-control w-50">
                    @else
                    <span wire:click="setEditIndex({{ $key }})">{{ $currency['name'] }}</span>
                    @endif</a>
                <td>
                    @if ($editIndex === $key)
                    <input type="text" wire:model.defer="currencies.{{ $key }}.code" class="form-control w-50">
                    @else
                    <span wire:click="setEditIndex({{ $key }})">{{ $currency['code'] }}</span>
                    @endif
                    </a>
                <td>@if ($editIndex === $key)
                    <input type="text" wire:model.defer="currencies.{{ $key }}.symbol" class="form-control w-50">
                    @else
                    <span wire:click.defer="setEditIndex({{ $key }})">{{ $currency['symbol'] }}</span>
                    @endif
                </td>
                </td>
                <td>
                    <button wire:click="updateCurrency({{ $currency['id'] }}, {{ $key }})" class="btn"
                        style="color: var(--color); border: 1px solid var(--color);"><i
                            class="uil uil-edit"></i></button>
                    <button wire:click="deleteCurrency({{ $currency['id'] }})"
                        style="color: red; border: 1px solid red;" class="btn ml-1"><i
                            class="uil uil-trash"></i></button>
                </td>
            </tr>
            @endforeach
            @endisset
        </tbody>
    </table>
    @push('scripts')
    <script>
        <script>
    document.addEventListener('livewire:init', () => {
       Livewire.on('reinitializeDataTable', (event) => {
        $("#datatable").DataTable();
        });
    });
    </script>

    </script>
    @endpush
</div>