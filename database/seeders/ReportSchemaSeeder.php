<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports_schemas')->insert([
            'id' => 1,
            'name' => 'Revenue',
            'parent' => null
        ]);
            DB::table('reports_schemas')->insert([
                'id' => 2,
                'name' => 'Revenue from Equity Investments',
                'parent' => 1
            ]);
                DB::table('reports_schemas')->insert([
                    'id' => 3,
                    'name' => 'Revenue from  Value Investments',
                    'parent' => 2
                ]);
                    DB::table('reports_schemas')->insert([
                        'id' => 4,
                        'name' => 'Dividends Received',
                        'parent' => 3
                    ]);
                    DB::table('reports_schemas')->insert([
                        'id' => 5,
                        'name' => 'Unrealized Holding Gain (loss) Value investments',
                        'parent' => 3
                    ]);
                    DB::table('reports_schemas')->insert([
                        'id' => 6,
                        'name' => 'Realized Capital Gains(loss)in valuesinvestments',
                        'parent' => 3
                    ]);
                DB::table('reports_schemas')->insert([
                    'id' => 7,
                    'name' => 'Revenue from  Growth  Investments',
                    'parent' => 2
                ]);
                    DB::table('reports_schemas')->insert([
                        'id' => 8,
                        'name' => 'Unrealized Holding Gain (loss) Growth investments',
                        'parent' => 7
                    ]);
                    DB::table('reports_schemas')->insert([
                        'id' => 9,
                        'name' => 'Dividends Received',
                        'parent' => 7
                    ]);
                    DB::table('reports_schemas')->insert([
                        'id' => 10,
                        'name' => 'Realized Capital Gains (loss) in growth  investments',
                        'parent' => 7
                    ]);
            DB::table('reports_schemas')->insert([
                'id' => 11,
                'name' => 'Revenue From debts Investments',
                'parent' => 1
            ]);
                DB::table('reports_schemas')->insert([
                    'id' => 12,
                    'name' => 'Revenue from AFS Debt Investments',
                    'parent' => 11
                ]);
                DB::table('reports_schemas')->insert([
                    'id' => 13,
                    'name' => 'Interest Gains',
                    'parent' => 11
                ]);
                DB::table('reports_schemas')->insert([
                    'id' => 14,
                    'name' => 'Amortized discounts and premiuns',
                    'parent' => 11
                ]);
    }
}
