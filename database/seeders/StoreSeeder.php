<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->insert(
            [
                'id'=> '84975485210',
                'name' => 'Techno322', 
                'user_id' => 2, 
                'email'=> 'tahirfarman123@gmail.com', 
                'api_key' => 'be67a5f7eafaaf86eb21f880ac0d0147', 
                'api_secret_key' => '81680f619fbd754f72a00db463b3fbcc', 
                'myshopify_domain' => 'techno322.myshopify.com', 'access_token' => 
                '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', 
                'image' => 'asset/img/logo.png'
                ]
        );
    }
}
