<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeCategorySeederBalance extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $code_categories = [
            // lvl 1
            [
                'id' => 39,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Assets',
            ],
            [
                'id' => 40,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Liabilities',
            ],
            [
                'id' => 41,
                'parent' => null,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Equity',
            ],
            // Lvl 2
            [
                'id' => 42,
                'parent' => 39,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Current Assets',
            ],
            [
                'id' => 43,
                'parent' => 39,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Fixed Assets',
            ],
            [
                'id' => 44,
                'parent' => 40,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Short-term Liabilites',
            ],
            [
                'id' => 45,
                'parent' => 40,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Long-Term Liabilites',
            ],
            [
                'id' => 46,
                'parent' => 41,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Equity',
            ],
            // lvl 3
            [
                'id' => 47,
                'parent' => 42,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Cash and cash equivalents',
            ],
            [
                'id' => 48,
                'parent' => 42,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Short-term Assets listed Stock Exchange',
            ],
            [
                'id' => 49,
                'parent' => 42,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Accounts receivable trade and services',
            ],
            [
                'id' => 50,
                'parent' => 42,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other short-term reveivables',
            ],
            [
                'id' => 51,
                'parent' => 42,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Prepaid Expenses',
            ],
            [
                'id' => 52,
                'parent' => 43,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Financial assets',
            ],
            [
                'id' => 53,
                'parent' => 43,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Investments',
            ],
            [
                'id' => 54,
                'parent' => 43,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Tangible assets',
            ],
            [
                'id' => 55,
                'parent' => 43,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Intangible fixed assets',
            ],
            [
                'id' => 56,
                'parent' => 43,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Capital or non-paid Foundation capital',
            ],
            [
                'id' => 57,
                'parent' => 44,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Suppliers or creditors',
            ],
            [
                'id' => 58,
                'parent' => 44,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Short-term onorous debts',
            ],
            [
                'id' => 59,
                'parent' => 44,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other short-term debts',
            ],
            [
                'id' => 60,
                'parent' => 44,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other short-term debts social insurances',
            ],
            [
                'id' => 61,
                'parent' => 45,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Accruals and deferred income',
            ],
            [
                'id' => 62,
                'parent' => 45,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Long-term onorous debts',
            ],
            [
                'id' => 63,
                'parent' => 45,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Other long-term debts',
            ],
            [
                'id' => 64,
                'parent' => 45,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Provisions',
            ],
            [
                'id' => 65,
                'parent' => 46,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Capital or captial of the foundation',
            ],
            [
                'id' => 66,
                'parent' => 46,
                'user_id' => 1,
                'company_id' => 1,
                'name' => 'Legal Reserves, profit oder loss',
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
