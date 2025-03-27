<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function runAccount(): void
    {
        DB::table('account')->insert([
            'account_uuid' => '1',
            'name' => 'Admin',
            'account_type_uuid' => '',
            'created_at' => 'User',
            'updated_at' => 'Second Lastname',
            'deleted_at' => 'admin@admin.com',
        ]);
    }
}
