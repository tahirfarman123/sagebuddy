<?php

namespace App\Livewire\Setting;

use Livewire\Component;
use App\Models\Currency;

class CurrencyManager extends Component
{
    public $currencies;
    public $newCurrencyName;
    public $newCodeName;
    public $newSymbolName;
    public $editIndex = null;
    public function mount()
    {
        $this->currencies = Currency::all()->toArray();
        $this->dispatch('reinitializeDataTable');
    }

    public function updateCurrency($currencyId, $index)
    {
        // dd($this->currencies[$index]['name']);
        Currency::find($currencyId)->update(['name' => $this->currencies[$index]['name'], 'code' => $this->currencies[$index]['code'], 'symbol' => $this->currencies[$index]['symbol']]);
        $this->currencies = Currency::all()->toArray();
        $this->editIndex = null;
        $this->dispatch('reinitializeDataTable');
    }
    public function setEditIndex($index)
    {
        $this->editIndex = $index;
        $this->dispatch('reinitializeDataTable');
    }

    public function deleteCurrency($currencyId)
    {
        Currency::find($currencyId)->delete();
        $this->currencies = Currency::all()->toArray();
        $this->dispatch('reinitializeDataTable');
    }

    public function saveCurrency()
    {
        $this->validate([
            'newCurrencyName' => 'required',
            'newSymbolName' => 'required',
            'newCodeName' => 'required',
        ]);

        Currency::create(['name' => $this->newCurrencyName, 'code' => $this->newCodeName, 'symbol' => $this->newSymbolName]);

        // After saving, you may want to refresh the currencies list

        $this->newCurrencyName = '';
        $this->newSymbolName = '';
        $this->currencies = Currency::all()->toArray();
        $this->dispatch('reinitializeDataTable');
    }

    public function render()
    {
        return view('livewire.setting.currency-manager');
    }
}
