<div class="">
    <h4>Courier Manage</h4>
    @can('all-access')
    <button class="btn btn-outline-primary ml-1" data-toggle="modal" data-target="#courier">Add New</button>
    @endcan
    @if ($this->authRole == 'Admin')
    <div class="row">
        @foreach ($couriers as $courier)
        <div class="col-md-3 card p-3">
            <div class="d-flex">
                <div class="w-50">{{ $courier->name }}</div>
                @foreach ($courier->courierSettings as $item)
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="toggleStatus{{ $item->table_id }}"
                        wire:model="status.{{ $item->id }}" wire:click="toggleCourierStatus({{ $item->table_id }})" {{
                        $status[$item->id] == '1' ? 'checked' : '' }}
                    >
                    <label class="custom-control-label" for="toggleStatus{{ $item->table_id }}">Status</label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    @endif

    <div class="row">
        @foreach ($couriers as $courier)



        <div class="col-md-6 card p-3" @if (count($courier->courierSettings) != 0)
            @if ($courier->courierSettings[0]->status == 0)
            style=" display: none;"
            @endif
            @endif
            >
            <div>
                <img src="{{ asset($courier->image) }}" width="70px" class="img-thumbnail" alt="">
                <label>{{$courier->name}}</label>
            </div>
            @if ($error != '')
            <span class="alert alert-danger">{{ $error }}</span>
            @endif
            @if ($success != '')
            <span class="alert alert-success">{{ $success }}</span>
            @endif
            <form wire:submit.prevent="saveCourierSetting('{{ $courier->table_id }}')">
                <!-- ... Your existing code ... -->
                <div>
                    @if ($courier->name == 'MnP')
                    @foreach ($courier->courierSettings as $item)
                    @if ($item->user_id == auth()->user()->id)
                    @php
                    $data = json_decode($item->value, true);
                    $this->username = $data['username'];
                    $this->password = $data['password'];
                    $this->accountno = $data['accountNo'];
                    @endphp
                    @else
                    @php
                    $data = json_decode($item->value, true);
                    $this->username = '';
                    $this->password = '';
                    $this->accountno = '';
                    @endphp
                    @endif
                    @endforeach
                    <label for="">Username</label>
                    <input type="text" class="form-control Input" wire:model.defer="username"
                        placeholder="Enter courier service Username" value="{{ $username }}">
                    <label for="">Password</label>
                    <input type="text" class="form-control Input" wire:model.defer="password"
                        placeholder="Enter courier service Password" value="{{ $password }}">
                    <label for="">Account No</label>
                    <input type="text" class="form-control Input" wire:model.defer="accountno"
                        placeholder="Enter courier service AccountNo" value="{{ $accountno }}">
                    @else
                    @endif
                </div>
                <div class="d-flex justify-content-end mt-1">
                    <button type="submit" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
        @endforeach

    </div>
</div>