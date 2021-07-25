<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $code_categories = [
            [
                'id' => 1,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Income',
            ],
            [
                'id' => 2,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Direct Operational Cost',
            ],
            [
                'id' => 3,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other Operational Cost',
            ],
            [
                'id' => 4,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Operating Expenses',
            ],
            [
                'id' => 5,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Depreciation and Amortization',
            ],
            [
                'id' => 6,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Financial Cost',
            ],
            [
                'id' => 7,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other Income/Expenses',
            ],
            [
                'id' => 8,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Non-company related expenditures/Income',
            ],
            [
                'id' => 9,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Taxes',
            ],
            // Level 2
            // Income -> Parent 1
            [
                'id' => 10,
                'parent' => 1,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Income from Services',
            ],
            [
                'id' => 11,
                'parent' => 1,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Income from  equity Securities',
            ],
            [
                'id' => 12,
                'parent' => 1,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Income From Private equity Gains',
            ],
            [
                'id' => 13,
                'parent' => 1,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Income from Debt Securities',
            ],
            [
                'id' => 14,
                'parent' => 1,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Income from Cash Markets',
            ],
            [
                'id' => 15,
                'parent' => 1,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Income from IP',
            ],
            [
                'id' => 16,
                'parent' => 1,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Income from Cryptocurrency',
            ],
            [
                'id' => 17,
                'parent' => 1,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other income',
            ],
            // Direct Operational Cost -> Parent 2
            [
                'id' => 18,
                'parent' => 2,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Associated Cost to investments',
            ],
            [
                'id' => 19,
                'parent' => 2,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Cost associated with intelectual property development',
            ],
            // Other Operational Cost -> Parent 3
            [
                'id' => 20,
                'parent' => 3,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Salary cost Services ',
            ],
            [
                'id' => 21,
                'parent' => 3,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Contribution to social insurance',
            ],
            [
                'id' => 22,
                'parent' => 3,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other personnel expenses',
            ],
            // Operating Expenses -> Parent 4
            [
                'id' => 23,
                'parent' => 4,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Rent',
            ],
            [
                'id' => 24,
                'parent' => 4,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Maintenace, repairs,  replacem. of tangible assets',
            ],
            [
                'id' => 25,
                'parent' => 4,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Vehicle and transportation expenses',
            ],
            [
                'id' => 26,
                'parent' => 4,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Insurance for damage of items',
            ],
            [
                'id' => 27,
                'parent' => 4,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Utilities',
            ],
            [
                'id' => 28,
                'parent' => 4,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Administrative and IT costs',
            ],
            [
                'id' => 29,
                'parent' => 4,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Advertising',
            ],
            [
                'id' => 30,
                'parent' => 4,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other expenses',
            ],
            // Depreciation and Amortization -> Parent 5
            [
                'id' => 31,
                'parent' => 5,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Depreciation and value adjustments of fixed assests',
            ],
            // Financial Cost -> Parent 6
            [
                'id' => 32,
                'parent' => 6,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Financial costs',
            ],
            // Other Income/Expenses -> Parent 7
            [
                'id' => 33,
                'parent' => 7,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Rental Income',
            ],
            [
                'id' => 34,
                'parent' => 7,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Gains on tangible fixed assets',
            ],
            // Non-company related expenditures/Income -> Parent 8
            [
                'id' => 35,
                'parent' => 8,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Non-company related expenditures',
            ],
            [
                'id' => 36,
                'parent' => 8,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Non-company related income',
            ],
            // Taxes -> Parent 9
            [
                'id' => 37,
                'parent' => 9,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Cantonal and municipal taxes',
            ],
            [
                'id' => 38,
                'parent' => 9,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Direct federal taxes',
            ],
        ];

        DB::table('code_categories')->insert($code_categories);

        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('code_categories')->update($update);
    }
}
