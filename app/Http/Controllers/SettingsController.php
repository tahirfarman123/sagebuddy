<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function settings()
    {
        return view('settings.index');
    }
    public function profile()
    {
        $user = auth()->user();
        $currencies = Currency::all();
        return view('settings.profile.index', ['user' => $user, 'currencies' => $currencies]);
    }
    public function updateProfile(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request['password']);
        $user->currency_id = $request->currency_id;
        $user->update();

        return back()->with('success', 'User Profile Updated!');
    }
}
