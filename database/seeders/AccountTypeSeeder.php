<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class AccountTypeSeeder extends Seeder

{

    /**

     * Run the database seeds.

     */

    public function run(): void

    {

        $accountTypes = [

            'Efectivo',

            'Cuenta de Ahorro',

            'Tarjeta de Crédito',

            'Cuenta Corriente',

            'Inversiones'

        ];

        foreach ($accountTypes as $type) {

            DB::table('account_type')->insert([

                'name' => $type,

                'account_type_uuid' => Str::uuid(),

                'created_at' => now(),

                'updated_at' => now(),

            ]);

        }

    }

}
