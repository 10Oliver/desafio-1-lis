<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class IncomeTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('income_type')->insert([
            [
                'income_type_uuid' => (string) Str::uuid(),
                'name' => 'Sueldo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'income_type_uuid' => (string) Str::uuid(),
                'name' => 'Venta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'income_type_uuid' => (string) Str::uuid(),
                'name' => 'Servicio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'income_type_uuid' => (string) Str::uuid(),
                'name' => 'Inversión',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'income_type_uuid' => (string) Str::uuid(),
                'name' => 'Otro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
