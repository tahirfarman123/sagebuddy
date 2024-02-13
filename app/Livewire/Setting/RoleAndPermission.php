<?php

namespace App\Livewire\Setting;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermission extends Component
{
    public $roles;
    public $roles1;
    public $newRoleName;
    public $permissions;
    public $newPermissionName;
    public $selectedPermissions = [];
    public $selectedRole;

    public function mount()
    {
        // dd($this->selectedPermission);

        // Fetch existing roles from the database
        $this->roles = Role::all()->toArray();
        $this->roles1 = Role::with('permissions')->get();
        // dd($this->roles1[0]['permissions']['name']);

        $this->permissions = Permission::all()->toArray();
    }

    public function selectRole($rolId)
    {
        $this->selectedRole = $rolId;
    }
    public function updateRolesAndPermissions()
    {

        $role = Role::where('id', $this->selectedRole)->first();
        $role->givePermissionTo($this->selectedPermissions);
    }

    public function saveRole()
    {
        // Validate and create a new role
        $this->validate([
            'newRoleName' => 'required|string|unique:roles,name',
        ]);

        Role::create([
            'name' => $this->newRoleName,
        ]);

        // Clear the input field after creating a new role
        $this->newRoleName = '';

        // Refresh the roles array after creating a new role
        $this->roles = Role::all()->toArray();
    }

    public function updateRole($roleId, $index)
    {
        // dd()
        // Find the role by ID
        $role = Role::find($roleId);
        // dd();

        // Validate the updated name for uniqueness, excluding the current role ID
        // $this->validate([
        //     "roles[$index]['name']" => 'required|string|unique:roles,name,' . $roleId,
        // ]);
        // dd($this->roles[$roleId]['name']);

        // Update the role's name
        $role->name = $this->roles[$index]['name'];
        $role->update();

        // Optionally, you can refresh the roles array without querying the database again
        $this->refreshRoles();
    }
    private function refreshRoles()
    {
        // Fetch existing roles from the database
        $this->roles = Role::all()->toArray();
    }

    public function deleteRole($roleId)
    {
        // Find the role by ID and delete it
        Role::find($roleId)->delete();

        // Refresh the roles array after deleting a role
        $this->roles = Role::all()->toArray();
    }
    public function savePermission()
    {
        // dd($this->newPermissionName);
        // Validate and create a new role
        $this->validate([
            'newPermissionName' => 'required',
        ]);

        Permission::create([
            'name' => $this->newPermissionName,
            'guard_name' => 'web',
        ]);


        // Clear the input field after creating a new role
        $this->newPermissionName = '';

        // Refresh the roles array after creating a new role
        $this->permissions = Permission::all()->toArray();
    }

    public function updatePermission($permissionId, $index)
    {
        // Find the role by ID and update its name
        $permi = Permission::find($permissionId);

        // $this->validate([
        //     "permissions.{$permissionId}.name" => 'required,' . $permissionId,
        // ]);
        $permi->name = $this->permissions[$index]['name'];
        $permi->update();

        // Refresh the roles array after updating a role
        $this->permissions = Permission::all()->toArray();
    }

    public function deletePermission($permissionId)
    {
        // Find the role by ID and delete it
        Permission::find($permissionId)->delete();

        // Refresh the roles array after deleting a role
        $this->permissions = Permission::all()->toArray();
    }
    public function render()
    {
        return view('livewire.setting.role-and-permission');
    }
}
