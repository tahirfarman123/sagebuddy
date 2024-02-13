<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::updateOrCreate([
            'email' => 'superadmin@shopify.com'
        ],[
            'name' => 'SuperAdmin',
            'currency_id' => 1,
            'email' => 'superadmin@shopify.com',
            'password' => Hash::make('123456')
        ]);
        $superadmin->assignRole('SuperAdmin');
        $superadmin = User::updateOrCreate([
            'email' => 'tahirfarman123@gmail.com'
        ],[
            'name' => 'Admin',
            'currency_id' => 1,
            'email' => 'tahirfarman123@gmail.com',
            'password' => Hash::make('123456')
        ]);
        $superadmin->assignRole('Admin');
    }
}
