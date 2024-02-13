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
    public $username;
    public $password;
    public $accountno;
    public $status = [];
    public $key4;
    public $image;
    public $courier_id;
    public $keyValues = [];
    public $courier_values = [];
    public $authRole;
    public $error = '';
    public $success = '';
    public function mount()
    {
        $this->authRole = auth()->user()->roles[0]->name;
        $this->couriers = Courier::with('courierSettings')->where('status', 1)->get();
        foreach ($this->couriers as $courier) {
            foreach ($courier->courierSettings as $setting) {
                $this->status[$setting->id] = $setting->status;
            }
        }
    }
    public function render()
    {
        return view('livewire.setting.courier-management');
    }
    // public function saveCourier($courierId)
    // {
    //     $courier = Courier::find($courierId)->pluck('key');
    //     $courier_keys = array_filter(explode(',', $courier[0]), 'strlen');
    //     $new = array();
    //     foreach ($courier_keys as $index => $key) {
    //         $new[$key] =  $this->keyValues[$index];
    //     }

    //     $value = implode(',', $new);


    //     $this->courier_id = $courierId;
    //     CourierSetting::updateorcreate([
    //         'courier_id' => $this->courier_id,
    //         'value' => $value,
    //         'user_id' => auth()->user()->id,
    //     ]);
    // foreach ($this->couriers as $courier) {
    //     if ($courier->table_id == $tableId) {
    //         foreach ($courier->courierIndex as $index => $courierIndex) {
    //             $value = request()->input("couriers.$tableId.$index");

    //             // Update or create CourierSetting
    //             CourierSetting::updateOrCreate(
    //                 [
    //                     'courier_id' => $courier->id,
    //                     'value' => $value,
    //                     'user_id' => auth()->user()->id,
    //                 ]
    //             );
    //         }
    //     }
    // }

    // Add any additional logic or redirection if needed

    // Clear the form input values
    // $this->resetInputValues();
    // }
    public function toggleCourierStatus($courierSettingId)
    {
        $courierSetting = CourierSetting::find($courierSettingId);

        if ($courierSetting) {
            $newStatus = $courierSetting->status == '1' ? '0' : '1';
            $courierSetting->status = $newStatus;
            $courierSetting->update();

            // Update the status in the Livewire component
            $this->status[$courierSettingId] = $newStatus;
        }
    }

    public function saveCourierSetting($courierId)
    {
        $courierSetting = CourierSetting::where('courier_id', $courierId)->where('user_id', auth()->user()->id)->first();
        $username = $this->username;
        $password = $this->password;
        $passwordAccountNo = $this->accountno;
        $encodedPassword = urlencode($password);
        $api_url = 'http://mnpcourier.com/mycodapi/api/Locations/Get_locations' . "?username=$username&password=$encodedPassword&AccountNo=$passwordAccountNo";

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $responseData = json_decode($response);
        if ($responseData->isSucces == false) {
            $this->error = $responseData->message;
        }

        if ($courierSetting) {
            $value = [
                'username' => $this->username,
                'password' => $this->password,
                'accountNo' => $this->accountno,
            ];
            // dd($responseData->locationList[0]->locationID);
            $courierSetting->value = $value;
            $courierSetting->location_id = $responseData->locationList[0]->locationID;
            $courierSetting->update();
            if ($responseData->isSucces == true) {
                $this->success = $responseData->message;
            }
        } else {
            $value = [
                'username' => $this->username,
                'password' => $this->password,
                'accountNo' => $this->accountno,
            ];


            // Build the URL with query parameters

            // dd($responseData->locationList[0]->locationID);
            if ($responseData->isSucces == true) {

                $courierSetting = new CourierSetting();
                $courierSetting->courier_id = $courierId;
                $courierSetting->location_id = $responseData->locationList[0]->locationID;
                $courierSetting->value = json_encode($value);
                $courierSetting->user_id = auth()->user()->id;
                $courierSetting->save();
                if ($responseData->isSucces == true) {
                    $this->success = $responseData->message;
                }
            }
        }
        curl_close($ch);
        $this->couriers = Courier::with('courierSettings')->where('status', 1)->get();
        foreach ($this->couriers as $courier) {
            foreach ($courier->courierSettings as $setting) {
                $this->status[$setting->id] = $setting->status;
            }
        }
        $this->success = '';
        $this->error = '';
    }

    private function resetInputValues()
    {
        // Reset the input values to prevent old values from being displayed
        $this->reset('couriers');
    }

    public function save()
    {
        // $value = [
        //     'key1' => $this->key1,
        //     'key2' => $this->key2,
        //     'key3' => $this->key3,
        //     'key4' => $this->key4,
        // ];
        // $newvalue = implode(',', $value);
        // dd($this->name);
        // dd($newvalue);
        if (!is_string($this->image)) {
            $filename = uniqid('image_') . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('public', $filename, 'public');
            $filePath = 'public/image/' . $filename;
            $this->image = $filePath;
        }

        $courier = Courier::Create([
            'name' => $this->name,
            'image' => $this->image
        ]);
        // foreach ($value as $val) {
        //     if ($val !== null) {
        //         CourierIndex::Create([
        //             'name' => $val,
        //             'courier_id' => $courier['table_id'],
        //         ]);
        //     }
        // }
        $this->couriers = Courier::with('courierSettings')->where('status', 1)->get();

        $this->dispatch('close-modal');
    }
}
