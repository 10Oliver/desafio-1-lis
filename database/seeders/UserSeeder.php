<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            'user_uuid' => '2c0f020b-c477-4281-9954-26aae87a78b9',
            'first_name' => 'Admin',
            'second_name' => 'Second name',
            'lastname' => 'User',
            'second_lastname' => 'Second Lastname',
            'email' => 'admin@admin.com',
            'phone' => '7485-8596',
            'dui' => '12345678-9',
            'password' => Hash::make('Admin123'),
        ]);
    }
}
