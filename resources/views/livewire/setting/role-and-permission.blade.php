<div class="row w-100">
    <div class="col-md-6">
        <h4 class="pt-2">Roles</h4>
        @foreach ($roles as $index => $role)
        <div class="row">
            <div class="col-sm-8 mb-1">
                <input type="text" class="form-control" value="{{ $role['name'] }}"
                    wire:model.defer="roles.{{ $index }}.name" name="role_name">
                @error("roles.{{ $index }}.name")
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-sm-4 mb-1">
                <button class="btn" wire:click="selectRole({{ $role['id'] }})"
                    style=" color: var(--color); border: 1px solid var(--color);" data-toggle="modal"
                    data-target="#assign-permission">@include('component.permission-icon')</button>
                <button wire:click="updateRole({{ $role['id'] }}, {{ $index }})" class="btn"
                    style="color: var(--color); border: 1px solid var(--color);"><i class="uil uil-edit"></i></button>
                <button wire:click="deleteRole({{ $role['id'] }})" class="btn btn"
                    style="color: red; border: 1px solid red;"><i class="uil uil-trash"></i></button>
            </div>
        </div>
        @endforeach
        <div class="row">
            <div class="col-sm-9 m-1">
                <input type="text" class="form-control" value="" name="role_name" wire:model.defer="newRoleName"
                    required>
                @error('newRoleName')
                <span class="badge bg-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-sm-1 m-1">
                <button wire:click="saveRole" class="btn"
                    style="color: var(--color); border: 1px solid var(--color);"><i class="uil uil-plus"></i></button>
            </div>
        </div>


    </div>
    <div class="col-md-6">
        <h4 class="pt-2">Permission</h4>
        <div class="row">
            @foreach ($permissions as $index => $permission)
            <div class="col-md-6 pt-2 d-flex">
                <div class="">
                    <input type="text" class="form-control" value="{{ $permission['name'] }}"
                        wire:model.defer="permissions.{{ $index }}.name" name="role_name">
                    @error("permissions.{$index}.name")
                    <span class="badge bg-danger">{{$message}}</span>
                    @enderror
                </div>
                <button wire:click="updatePermission({{ $permission['id'] }}, {{ $index }})" class="btn"
                    style="color: var(--color); border: 1px solid var(--color);"><i class="uil uil-edit"></i></button>
                <button wire:click="deletePermission({{ $permission['id'] }})"
                    style="color: red; border: 1px solid red;" class="btn ml-1"><i class="uil uil-trash"></i></button>

            </div>
            @endforeach
            <div class="col-md-6 pt-2 d-flex">
                <div class="">
                    <input type="text" class="form-control" value="" name="permission_name"
                        wire:model.defer="newPermissionName" required>
                    @error('newPermissionName')
                    <span class="badge bg-danger">{{$message}}</span>
                    @enderror
                </div>
                <button wire:click="savePermission" class="btn"
                    style="color: var(--color); border: 1px solid var(--color);"><i class=" uil uil-plus"></i></button>
                <div></div>
            </div>

        </div>
    </div>
    <div wire:ignore class="modal fade" id="assign-permission">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="updateRolesAndPermissions">
                    <div class="modal-header">
                        <h4 class="modal-title">Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="lable-f">Select Permission</label>
                                <div class="row">
                                    @foreach($permissions as $index => $permission)
                                    <div class="col-md-4">
                                        <label>
                                            <input type="checkbox" wire:model="selectedPermissions"
                                                value="{{ $permission['id'] }}" @foreach ($this->roles1 as $role)
                                            @foreach($role->permissions as $permi)
                                            @if ($permi->name == $permission['name'])
                                            @checked(true) checked
                                            @endif

                                            @endforeach
                                            @endforeach>
                                            {{
                                            $permission['name'] }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
  $('#select_permission').select2();

$('#select_permission').on('select2:select', function (e) {
  var value = e.params.data.id;
  if (value === 'all') {
    $('#select_permission option:not(:selected)').prop('selected', true);
    $('#select_permission').trigger('change');
  }
});

$('#select_permission').on('select2:unselect', function (e) {
  var value = e.params.data.id;
  if (value === 'all') {
    $('#select_permission option:selected').prop('selected', false);
    $('#select_permission').trigger('change');
  }
});
});
    </script>
</div>