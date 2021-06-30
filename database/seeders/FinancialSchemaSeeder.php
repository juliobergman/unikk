<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('financial_schemas')->insert([
            'id' => 1,
            'user_id' => 1,
            'company_id' => 1,
            'name' => 'First Report Schema'
        ]);

    }
}
