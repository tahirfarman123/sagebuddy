<?php

namespace App\Livewire\Setting;

use App\Models\Courier;
use App\Models\CourierIndex;
use App\Models\CourierSetting;
use App\Models\Currency;
use Livewire\Component;
use Livewire\WithFileUploads;

class CourierManagement extends Component
{
    use WithFileUploads;
    public $couriers;
    public $name;
    public $key1;
    public $key2;
    public $key3;
    public $key4;
    public $image;
    public $courier_id;
    public $keyValues = [];
    public function mount($couriers)
    {
        $this->couriers = Courier::with('courierIndex')->where('status', 1)->get();
    }
    public function render()
    {
        return view('livewire.setting.courier-management');
    }
    public function saveCourier($courierId)
    {
        dd($this->keyValues);
        foreach ($this->couriers as $courier) {
            if ($courier->table_id == $courierId) {
                foreach ($courier->courierIndex as $index => $courierIndex) {
                    $value = request()->input("couriers.$courierId.$index");
                    dd($value);

                    // Update or create CourierSetting
                    CourierSetting::updateOrCreate(
                        [
                            'courier_id' => $courier->id,
                            'value' => $value,
                            'user_id' => auth()->user()->id,
                        ]
                    );
                }
            }
        }


        // $courier = CourierIndex::where('courier_id', $courierId)->pluck('name');
        // $new = array();
        // foreach ($courier as $index => $key) {
        //     $new[$key] =  $this->keyValues[$index];
        // }
        // dd($new);

        // $value = implode(',', $new);


        // $this->courier_id = $courierId;
        // CourierSetting::updateorcreate([
        //     'courier_id' => $this->courier_id,
        //     'value' => $value,
        //     'user_id' => auth()->user()->id,
        // ]);
    }

    public function save()
    {
        $value = [
            'key1' => $this->key1,
            'key2' => $this->key2,
            'key3' => $this->key3,
            'key4' => $this->key4,
        ];
        // $newvalue = implode(',', $value);
        // dd($this->name);
        // dd($newvalue);
        if (!is_string($this->image)) {
            $filename = uniqid('image_') . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('livewire', $filename, 'livewire');
            $filePath = 'public/livewire/' . $filename;
            $this->image = $filePath;
        }

        $courier = Courier::Create([
            'name' => $this->name,
            'image' => $this->image
        ]);
        foreach ($value as $val) {
            if ($val !== null) {
                CourierIndex::Create([
                    'name' => $val,
                    'courier_id' => $courier['table_id'],
                ]);
            }
        }
        $this->couriers = Courier::all();

        $this->dispatch('close-modal');
    }
}
