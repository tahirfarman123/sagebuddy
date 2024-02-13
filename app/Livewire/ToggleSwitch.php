<?php

namespace App\Livewire;

use Livewire\Component;

class ToggleSwitch extends Component
{
    public $isActive = false;
    public function toggleStatus()
    {
        $this->isActive = !$this->isActive;
    }
    public function render()
    {
        return view('livewire.toggle-switch');
    }
}
