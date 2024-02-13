<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="customSwitch1" wire:model="isActive"
        wire:click="toggleStatus">
    <label class="custom-control-label" for="customSwitch1">
        {{ $isActive ? 'Active' : 'Deactive' }}
    </label>
</div>