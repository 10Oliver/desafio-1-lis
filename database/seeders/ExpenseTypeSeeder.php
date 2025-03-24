<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ExpenseTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('expense_type')->insert([
            [
                'expense_type_uuid' => (string) Str::uuid(),
                'name' => 'Servicios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'expense_type_uuid' => (string) Str::uuid(),
                'name' => 'Alquiler',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'expense_type_uuid' => (string) Str::uuid(),
                'name' => 'Materiales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'expense_type_uuid' => (string) Str::uuid(),
                'name' => 'Transporte',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'expense_type_uuid' => (string) Str::uuid(),
                'name' => 'Educación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'expense_type_uuid' => (string) Str::uuid(),
                'name' => 'Alimentación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'expense_type_uuid' => (string) Str::uuid(),
                'name' => 'Otro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
