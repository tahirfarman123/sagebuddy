<?php

namespace App\Livewire\Setting;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StoreSetting extends Component
{
    public $currencies;
    public $currency_id;
    public $user;
    public function mount()
    {
        // dd($this->currency_id);
        $this->user = Auth::user();
        $this->currencies = Currency::all();
    }
    public function update()
    {
        $user = User::find($this->user->id);
        $user->currency_id = $this->currency_id;
        $user->update(['currency_id' => $this->currency_id]);
    }
    public function render()
    {
        return view('livewire.setting.store-setting');
    }
}
