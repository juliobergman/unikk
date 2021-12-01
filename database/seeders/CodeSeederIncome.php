<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeSeederIncome extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codes = [
            [
                'id' => 1,
                'company_id' => 1,
                'group' => 1,
                'oby' => 1,
                'code_category_id' => 10,
                'code' => 3400,
                'name' => 'Income from Services'
            ],
            [
                'id' => 2,
                'company_id' => 1,
                'group' => 1,
                'oby' => 2,
                'code_category_id' => 11,
                'code' => 3410,
                'name' => 'Revenue Dividends Income'
            ],
            [
                'id' => 3,
                'company_id' => 1,
                'group' => 1,
                'oby' => 3,
                'code_category_id' => 11,
                'code' => 3415,
                'name' => 'Revenue Unrealized gains in trading securities'
            ],
            [
                'id' => 4,
                'company_id' => 1,
                'group' => 1,
                'oby' => 4,
                'code_category_id' => 11,
                'code' => 3420,
                'name' => 'Earnings from short-term financial investments'
            ],
            [
                'id' => 5,
                'company_id' => 1,
                'group' => 1,
                'oby' => 5,
                'code_category_id' => 12,
                'code' => 3425,
                'name' => 'Realized gains in  Private equity Holdings'
            ],
            [
                'id' => 6,
                'company_id' => 1,
                'group' => 1,
                'oby' => 6,
                'code_category_id' => 13,
                'code' => 3430,
                'name' => 'Interest gains from AFS debt investments'
            ],
            [
                'id' => 7,
                'company_id' => 1,
                'group' => 1,
                'oby' => 7,
                'code_category_id' => 13,
                'code' => 3435,
                'name' => 'Realized gains on AFS debt invesments'
            ],
            [
                'id' => 8,
                'company_id' => 1,
                'group' => 1,
                'oby' => 8,
                'code_category_id' => 14,
                'code' => 3440,
                'name' => 'Return on bank deposits'
            ],
            [
                'id' => 9,
                'company_id' => 1,
                'group' => 1,
                'oby' => 9,
                'code_category_id' => 14,
                'code' => 3445,
                'name' => 'Exchange gains'
            ],
            [
                'id' => 10,
                'company_id' => 1,
                'group' => 1,
                'oby' => 10,
                'code_category_id' => 14,
                'code' => 3450,
                'name' => 'Other Interest gains'
            ],
            [
                'id' => 11,
                'company_id' => 1,
                'group' => 1,
                'oby' => 11,
                'code_category_id' => 15,
                'code' => 3455,
                'name' => 'Revenue from Royalties'
            ],
            [
                'id' => 12,
                'company_id' => 1,
                'group' => 1,
                'oby' => 12,
                'code_category_id' => 15,
                'code' => 3460,
                'name' => 'Revenue from IP sales'
            ],
            [
                'id' => 13,
                'company_id' => 1,
                'group' => 1,
                'oby' => 13,
                'code_category_id' => 16,
                'code' => 3465,
                'name' => 'Gains on Cryptocurrency holdings value'
            ],
            [
                'id' => 14,
                'company_id' => 1,
                'group' => 1,
                'oby' => 14,
                'code_category_id' => 17,
                'code' => 3490,
                'name' => 'Discount'
            ],
            [
                'id' => 15,
                'company_id' => 1,
                'group' => 1,
                'oby' => 15,
                'code_category_id' => 17,
                'code' => 3491,
                'name' => 'Rebates and price deductions'
            ],
            [
                'id' => 16,
                'company_id' => 1,
                'group' => 1,
                'oby' => 16,
                'code_category_id' => 17,
                'code' => 3495,
                'name' => 'Losses from receivables'
            ],
            [
                'id' => 17,
                'company_id' => 1,
                'group' => 1,
                'oby' => 17,
                'code_category_id' => 18,
                'code' => 4400,
                'name' => 'Costs of services'
            ],
            [
                'id' => 18,
                'company_id' => 1,
                'group' => 1,
                'oby' => 18,
                'code_category_id' => 18,
                'code' => 4410,
                'name' => 'Investments Comision'
            ],
            [
                'id' => 19,
                'company_id' => 1,
                'group' => 1,
                'oby' => 19,
                'code_category_id' => 18,
                'code' => 4415,
                'name' => 'Management fees'
            ],
            [
                'id' => 20,
                'company_id' => 1,
                'group' => 1,
                'oby' => 20,
                'code_category_id' => 18,
                'code' => 4420,
                'name' => 'Brokerage Comissions'
            ],
            [
                'id' => 21,
                'company_id' => 1,
                'group' => 1,
                'oby' => 21,
                'code_category_id' => 18,
                'code' => 4425,
                'name' => 'Management fees Private equity'
            ],
            [
                'id' => 22,
                'company_id' => 1,
                'group' => 1,
                'oby' => 22,
                'code_category_id' => 18,
                'code' => 4430,
                'name' => 'Interest from leveraged investments'
            ],
            [
                'id' => 23,
                'company_id' => 1,
                'group' => 1,
                'oby' => 23,
                'code_category_id' => 18,
                'code' => 4435,
                'name' => 'Bank investments comissions (Private Equity)'
            ],
            [
                'id' => 24,
                'company_id' => 1,
                'group' => 1,
                'oby' => 24,
                'code_category_id' => 18,
                'code' => 4440,
                'name' => 'Other Investments Comissions'
            ],
            [
                'id' => 25,
                'company_id' => 1,
                'group' => 1,
                'oby' => 25,
                'code_category_id' => 19,
                'code' => 3600,
                'name' => 'Labor fees'
            ],
            [
                'id' => 26,
                'company_id' => 1,
                'group' => 1,
                'oby' => 26,
                'code_category_id' => 19,
                'code' => 3610,
                'name' => 'Techological tools Cost'
            ],
            [
                'id' => 27,
                'company_id' => 1,
                'group' => 1,
                'oby' => 27,
                'code_category_id' => 19,
                'code' => 3615,
                'name' => 'Bank comissions'
            ],
            [
                'id' => 28,
                'company_id' => 1,
                'group' => 1,
                'oby' => 28,
                'code_category_id' => 19,
                'code' => 3620,
                'name' => 'Other incubation cost'
            ],
            [
                'id' => 29,
                'company_id' => 1,
                'group' => 1,
                'oby' => 29,
                'code_category_id' => 20,
                'code' => 5400,
                'name' => 'Salary cost Services'
            ],
            [
                'id' => 30,
                'company_id' => 1,
                'group' => 1,
                'oby' => 30,
                'code_category_id' => 20,
                'code' => 5401,
                'name' => 'Allowances Services'
            ],
            [
                'id' => 31,
                'company_id' => 1,
                'group' => 1,
                'oby' => 31,
                'code_category_id' => 20,
                'code' => 5402,
                'name' => 'Bonuses Services'
            ],
            [
                'id' => 32,
                'company_id' => 1,
                'group' => 1,
                'oby' => 32,
                'code_category_id' => 20,
                'code' => 5403,
                'name' => 'Commissions Services'
            ],
            [
                'id' => 33,
                'company_id' => 1,
                'group' => 1,
                'oby' => 33,
                'code_category_id' => 20,
                'code' => 5405,
                'name' => 'Social security benefits '
            ],
            [
                'id' => 34,
                'company_id' => 1,
                'group' => 1,
                'oby' => 34,
                'code_category_id' => 20,
                'code' => 5409,
                'name' => 'Director Fees'
            ],
            [
                'id' => 35,
                'company_id' => 1,
                'group' => 1,
                'oby' => 35,
                'code_category_id' => 21,
                'code' => 5700,
                'name' => 'AHV, IV, EO, ALV'
            ],
            [
                'id' => 36,
                'company_id' => 1,
                'group' => 1,
                'oby' => 36,
                'code_category_id' => 21,
                'code' => 5710,
                'name' => 'FAK'
            ],
            [
                'id' => 37,
                'company_id' => 1,
                'group' => 1,
                'oby' => 37,
                'code_category_id' => 21,
                'code' => 5720,
                'name' => 'Occupational pension'
            ],
            [
                'id' => 38,
                'company_id' => 1,
                'group' => 1,
                'oby' => 38,
                'code_category_id' => 21,
                'code' => 5730,
                'name' => 'Accident insurance'
            ],
            [
                'id' => 39,
                'company_id' => 1,
                'group' => 1,
                'oby' => 39,
                'code_category_id' => 21,
                'code' => 5740,
                'name' => 'Daily sickness insurance'
            ],
            [
                'id' => 40,
                'company_id' => 1,
                'group' => 1,
                'oby' => 40,
                'code_category_id' => 21,
                'code' => 5790,
                'name' => 'Tax at source'
            ],
            [
                'id' => 41,
                'company_id' => 1,
                'group' => 1,
                'oby' => 41,
                'code_category_id' => 22,
                'code' => 5800,
                'name' => 'Staff recruitment'
            ],
            [
                'id' => 42,
                'company_id' => 1,
                'group' => 1,
                'oby' => 42,
                'code_category_id' => 22,
                'code' => 5810,
                'name' => 'Vocational education and traiding'
            ],
            [
                'id' => 43,
                'company_id' => 1,
                'group' => 1,
                'oby' => 43,
                'code_category_id' => 22,
                'code' => 5880,
                'name' => 'Other employee expenses'
            ],
            [
                'id' => 44,
                'company_id' => 1,
                'group' => 2,
                'oby' => 44,
                'code_category_id' => 23,
                'code' => 6000,
                'name' => 'Rent'
            ],
            [
                'id' => 45,
                'company_id' => 1,
                'group' => 2,
                'oby' => 45,
                'code_category_id' => 24,
                'code' => 6101,
                'name' => 'Expenses Furnishings and equipment'
            ],
            [
                'id' => 46,
                'company_id' => 1,
                'group' => 2,
                'oby' => 46,
                'code_category_id' => 24,
                'code' => 6160,
                'name' => 'Leasing tangible fixed assets'
            ],
            [
                'id' => 47,
                'company_id' => 1,
                'group' => 2,
                'oby' => 47,
                'code_category_id' => 25,
                'code' => 6200,
                'name' => 'Vehicle repair, service'
            ],
            [
                'id' => 48,
                'company_id' => 1,
                'group' => 2,
                'oby' => 48,
                'code_category_id' => 25,
                'code' => 6210,
                'name' => 'Vehicle fuel'
            ],
            [
                'id' => 49,
                'company_id' => 1,
                'group' => 2,
                'oby' => 49,
                'code_category_id' => 25,
                'code' => 6220,
                'name' => 'Vehicle insurance / vehicle tax'
            ],
            [
                'id' => 50,
                'company_id' => 1,
                'group' => 2,
                'oby' => 50,
                'code_category_id' => 25,
                'code' => 6260,
                'name' => 'Vehicle leasing'
            ],
            [
                'id' => 51,
                'company_id' => 1,
                'group' => 2,
                'oby' => 51,
                'code_category_id' => 25,
                'code' => 6270,
                'name' => 'Private share Vehicle expenses'
            ],
            [
                'id' => 52,
                'company_id' => 1,
                'group' => 2,
                'oby' => 52,
                'code_category_id' => 26,
                'code' => 6300,
                'name' => 'Insurance premiums'
            ],
            [
                'id' => 53,
                'company_id' => 1,
                'group' => 2,
                'oby' => 53,
                'code_category_id' => 26,
                'code' => 6360,
                'name' => 'Duties and charges'
            ],
            [
                'id' => 54,
                'company_id' => 1,
                'group' => 2,
                'oby' => 54,
                'code_category_id' => 27,
                'code' => 6400,
                'name' => 'Electricity/water/gas'
            ],
            [
                'id' => 55,
                'company_id' => 1,
                'group' => 2,
                'oby' => 55,
                'code_category_id' => 28,
                'code' => 6500,
                'name' => 'Office material'
            ],
            [
                'id' => 56,
                'company_id' => 1,
                'group' => 2,
                'oby' => 56,
                'code_category_id' => 28,
                'code' => 6503,
                'name' => 'Magazines, books'
            ],
            [
                'id' => 57,
                'company_id' => 1,
                'group' => 2,
                'oby' => 57,
                'code_category_id' => 28,
                'code' => 6510,
                'name' => 'Telephone, internet'
            ],
            [
                'id' => 58,
                'company_id' => 1,
                'group' => 2,
                'oby' => 58,
                'code_category_id' => 28,
                'code' => 6513,
                'name' => 'Postage'
            ],
            [
                'id' => 59,
                'company_id' => 1,
                'group' => 2,
                'oby' => 59,
                'code_category_id' => 28,
                'code' => 6520,
                'name' => 'Contributions, donations'
            ],
            [
                'id' => 60,
                'company_id' => 1,
                'group' => 2,
                'oby' => 60,
                'code_category_id' => 28,
                'code' => 6530,
                'name' => 'Accounting expenses'
            ],
            [
                'id' => 61,
                'company_id' => 1,
                'group' => 2,
                'oby' => 61,
                'code_category_id' => 28,
                'code' => 6531,
                'name' => 'Legal consulting'
            ],
            [
                'id' => 62,
                'company_id' => 1,
                'group' => 2,
                'oby' => 62,
                'code_category_id' => 28,
                'code' => 6532,
                'name' => 'Tax consulting'
            ],
            [
                'id' => 63,
                'company_id' => 1,
                'group' => 2,
                'oby' => 63,
                'code_category_id' => 28,
                'code' => 6533,
                'name' => 'Other consulting expenses'
            ],
            [
                'id' => 64,
                'company_id' => 1,
                'group' => 2,
                'oby' => 64,
                'code_category_id' => 28,
                'code' => 6540,
                'name' => 'Gsuites expenses'
            ],
            [
                'id' => 65,
                'company_id' => 1,
                'group' => 2,
                'oby' => 65,
                'code_category_id' => 28,
                'code' => 6550,
                'name' => 'Cloud Storage expenses'
            ],
            [
                'id' => 66,
                'company_id' => 1,
                'group' => 2,
                'oby' => 66,
                'code_category_id' => 28,
                'code' => 6560,
                'name' => 'Leasing and rent HW + SW'
            ],
            [
                'id' => 67,
                'company_id' => 1,
                'group' => 2,
                'oby' => 67,
                'code_category_id' => 28,
                'code' => 6570,
                'name' => 'Licenses and maintenance'
            ],
            [
                'id' => 68,
                'company_id' => 1,
                'group' => 2,
                'oby' => 68,
                'code_category_id' => 29,
                'code' => 6600,
                'name' => 'Advertising'
            ],
            [
                'id' => 69,
                'company_id' => 1,
                'group' => 2,
                'oby' => 69,
                'code_category_id' => 29,
                'code' => 6610,
                'name' => 'Promotional print material'
            ],
            [
                'id' => 70,
                'company_id' => 1,
                'group' => 2,
                'oby' => 70,
                'code_category_id' => 29,
                'code' => 6620,
                'name' => 'Exhibitions / decoration'
            ],
            [
                'id' => 71,
                'company_id' => 1,
                'group' => 2,
                'oby' => 71,
                'code_category_id' => 29,
                'code' => 6630,
                'name' => 'Web Hostung services'
            ],
            [
                'id' => 72,
                'company_id' => 1,
                'group' => 2,
                'oby' => 72,
                'code_category_id' => 29,
                'code' => 6640,
                'name' => 'Travel expenses'
            ],
            [
                'id' => 73,
                'company_id' => 1,
                'group' => 2,
                'oby' => 73,
                'code_category_id' => 29,
                'code' => 6641,
                'name' => 'Representation expenses '
            ],
            [
                'id' => 74,
                'company_id' => 1,
                'group' => 2,
                'oby' => 74,
                'code_category_id' => 29,
                'code' => 6642,
                'name' => 'Customer gifts'
            ],
            [
                'id' => 75,
                'company_id' => 1,
                'group' => 2,
                'oby' => 75,
                'code_category_id' => 30,
                'code' => 6700,
                'name' => 'Other expenses'
            ],
            [
                'id' => 76,
                'company_id' => 1,
                'group' => 2,
                'oby' => 76,
                'code_category_id' => 31,
                'code' => 6800,
                'name' => 'Depreciation on financial assets'
            ],
            [
                'id' => 77,
                'company_id' => 1,
                'group' => 2,
                'oby' => 77,
                'code_category_id' => 31,
                'code' => 6820,
                'name' => 'Depreciation on machinery and appliances'
            ],
            [
                'id' => 78,
                'company_id' => 1,
                'group' => 2,
                'oby' => 78,
                'code_category_id' => 31,
                'code' => 6821,
                'name' => 'Depreciation on furniture and equipment'
            ],
            [
                'id' => 79,
                'company_id' => 1,
                'group' => 2,
                'oby' => 79,
                'code_category_id' => 31,
                'code' => 6822,
                'name' => 'Depreciation on office equipment and computers'
            ],
            [
                'id' => 80,
                'company_id' => 1,
                'group' => 2,
                'oby' => 80,
                'code_category_id' => 31,
                'code' => 6823,
                'name' => 'Depreciation on vehicles'
            ],
            [
                'id' => 81,
                'company_id' => 1,
                'group' => 2,
                'oby' => 81,
                'code_category_id' => 31,
                'code' => 6830,
                'name' => 'Depreciation on immovable fixes assets'
            ],
            [
                'id' => 82,
                'company_id' => 1,
                'group' => 2,
                'oby' => 82,
                'code_category_id' => 31,
                'code' => 6840,
                'name' => 'Depreciation on intangible assets'
            ],
            [
                'id' => 83,
                'company_id' => 1,
                'group' => 2,
                'oby' => 83,
                'code_category_id' => 31,
                'code' => 6850,
                'name' => 'Depreciation on capitalized expenditure'
            ],
            [
                'id' => 84,
                'company_id' => 1,
                'group' => 3,
                'oby' => 84,
                'code_category_id' => 32,
                'code' => 6901,
                'name' => 'Interest expenses on loans'
            ],
            [
                'id' => 85,
                'company_id' => 1,
                'group' => 3,
                'oby' => 85,
                'code_category_id' => 32,
                'code' => 6940,
                'name' => 'Other Bank Charges'
            ],
            [
                'id' => 86,
                'company_id' => 1,
                'group' => 3,
                'oby' => 86,
                'code_category_id' => 32,
                'code' => 6949,
                'name' => 'Exchange losses'
            ],
            [
                'id' => 87,
                'company_id' => 1,
                'group' => 3,
                'oby' => 87,
                'code_category_id' => 33,
                'code' => 7500,
                'name' => 'Rental income'
            ],
            [
                'id' => 88,
                'company_id' => 1,
                'group' => 3,
                'oby' => 88,
                'code_category_id' => 33,
                'code' => 7510,
                'name' => 'Property expenses'
            ],
            [
                'id' => 89,
                'company_id' => 1,
                'group' => 3,
                'oby' => 89,
                'code_category_id' => 34,
                'code' => 7910,
                'name' => 'Gains on tangible fixed assets'
            ],
            [
                'id' => 90,
                'company_id' => 1,
                'group' => 3,
                'oby' => 90,
                'code_category_id' => 35,
                'code' => 8000,
                'name' => 'Non-company related expenditures'
            ],
            [
                'id' => 91,
                'company_id' => 1,
                'group' => 3,
                'oby' => 91,
                'code_category_id' => 36,
                'code' => 8100,
                'name' => 'Non-company related income'
            ],
            [
                'id' => 92,
                'company_id' => 1,
                'group' => 4,
                'oby' => 92,
                'code_category_id' => 37,
                'code' => 8900,
                'name' => 'Cantonal and municipal taxes'
            ],
            [
                'id' => 93,
                'company_id' => 1,
                'group' => 4,
                'oby' => 93,
                'code_category_id' => 38,
                'code' => 8901,
                'name' => 'Direct federal taxes'
            ]
        ];

        DB::table('codes')->insert($codes);

        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('codes')->update($update);
    }
}
