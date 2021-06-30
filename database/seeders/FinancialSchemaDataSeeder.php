<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialSchemaDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Income
        DB::table('financial_schema_data')->insert([
            'id' => 1,
            'financial_schema_id' => 1,
            'name' => 'Income',
            'code' => null,
            'parent' => null,
        ]);

            DB::table('financial_schema_data')->insert([
                'id' => 2,
                'financial_schema_id' => 1,
                'name' => 'Income from Services',
                'code' => 3400,
                'parent' => 1,
            ]);

            DB::table('financial_schema_data')->insert([
                'id' => 3,
                'financial_schema_id' => 1,
                'name' => 'Income from  equity Securities',
                'code' => null,
                'parent' => 1,
            ]);

                DB::table('financial_schema_data')->insert([
                    'id' => 4,
                    'financial_schema_id' => 1,
                    'name' => 'Revenue Dividends Income',
                    'code' => 3410,
                    'parent' => 3,
                ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 5,
                    'financial_schema_id' => 1,
                    'name' => 'Revenue Unrealized gains in trading securities',
                    'code' => 3415,
                    'parent' => 3,
                ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 6,
                    'financial_schema_id' => 1,
                    'name' => 'Earnings from short-term financial investments',
                    'code' => 3420,
                    'parent' => 3,
                ]);

            DB::table('financial_schema_data')->insert([
                'id' => 7,
                'financial_schema_id' => 1,
                'name' => 'Income From Private equity Gains',
                'code' => null,
                'parent' => 1,
            ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 8,
                    'financial_schema_id' => 1,
                    'name' => 'Realized gains in  Private equity Holdings',
                    'code' => null,
                    'parent' => 7,
                ]);

            DB::table('financial_schema_data')->insert([
                'id' => 9,
                'financial_schema_id' => 1,
                'name' => 'Income from Debt Securities',
                'code' => null,
                'parent' => 1,
            ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 10,
                    'financial_schema_id' => 1,
                    'name' => 'Interest gains from AFS debt investments',
                    'code' => 3430,
                    'parent' => 9,
                ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 11,
                    'financial_schema_id' => 1,
                    'name' => 'Realized gains on AFS debt invesments',
                    'code' => 3435,
                    'parent' => 9,
                ]);



            DB::table('financial_schema_data')->insert([
                'id' => 12,
                'financial_schema_id' => 1,
                'name' => 'Income from Cash Markets',
                'code' => null,
                'parent' => 1,
            ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 13,
                    'financial_schema_id' => 1,
                    'name' => 'Return on bank deposits',
                    'code' => 3440,
                    'parent' => 12,
                ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 14,
                    'financial_schema_id' => 1,
                    'name' => 'Exchange gains',
                    'code' => 3445,
                    'parent' => 12,
                ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 15,
                    'financial_schema_id' => 1,
                    'name' => 'Other Interest gains',
                    'code' => 3450,
                    'parent' => 12,
                ]);



            DB::table('financial_schema_data')->insert([
                'id' => 16,
                'financial_schema_id' => 1,
                'name' => 'Income from IP',
                'code' => null,
                'parent' => 1,
            ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 17,
                    'financial_schema_id' => 1,
                    'name' => 'Revenue from Royalties',
                    'code' => 3455,
                    'parent' => 16,
                ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 18,
                    'financial_schema_id' => 1,
                    'name' => 'Revenue from IP sales',
                    'code' => 3460,
                    'parent' => 16,
                ]);

            DB::table('financial_schema_data')->insert([
                'id' => 19,
                'financial_schema_id' => 1,
                'name' => 'Income from Cryptocurrency',
                'code' => null,
                'parent' => 1,
            ]);

                DB::table('financial_schema_data')->insert([
                    'id' => 20,
                    'financial_schema_id' => 1,
                    'name' => 'Gains on Cryptocurrency holdings value',
                    'code' => null,
                    'parent' => 19,
                ]);

            DB::table('financial_schema_data')->insert([
                'id' => 21,
                'financial_schema_id' => 1,
                'name' => 'Other income',
                'code' => null,
                'parent' => 1,
            ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 22,
                    'financial_schema_id' => 1,
                    'name' => 'Discount',
                    'code' => 3490,
                    'parent' => 21,
                ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 23,
                    'financial_schema_id' => 1,
                    'name' => 'Rebates and price deductions',
                    'code' => 3491,
                    'parent' => 21,
                ]);
                DB::table('financial_schema_data')->insert([
                    'id' => 24,
                    'financial_schema_id' => 1,
                    'name' => 'Losses from receivables',
                    'code' => 3495,
                    'parent' => 21,
                ]);

        // Direct Operational Cost
        DB::table('financial_schema_data')->insert([
            // 'id' => 1,
            'financial_schema_id' => 1,
            'name' => 'Direct Operational Cost',
            'code' => null,
            'parent' => null,
        ]);
    }
}
