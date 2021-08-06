<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeSeederBalance extends Seeder
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
                'id' => 94,
                'group' => 5,
                'oby' => 1,
                'code_category_id' => 47,
                'code' => 1000,
                'name' => 'Cash on hand'
            ],
            [
                'id' => 95,
                'group' => 5,
                'oby' => 2,
                'code_category_id' => 47,
                'code' => 1010,
                'name' => 'EFG Bank'
            ],
            [
                'id' => 96,
                'group' => 5,
                'oby' => 3,
                'code_category_id' => 47,
                'code' => 1020,
                'name' => 'CIM Banque CHF'
            ],
            [
                'id' => 97,
                'group' => 5,
                'oby' => 4,
                'code_category_id' => 47,
                'code' => 1030,
                'name' => 'CIM Banque EUR'
            ],
            [
                'id' => 98,
                'group' => 5,
                'oby' => 5,
                'code_category_id' => 47,
                'code' => 1040,
                'name' => 'CIM Banque USD'
            ],
            [
                'id' => 99,
                'group' => 5,
                'oby' => 6,
                'code_category_id' => 47,
                'code' => 1050,
                'name' => 'Time deposits'
            ],
            [
                'id' => 100,
                'group' => 5,
                'oby' => 7,
                'code_category_id' => 48,
                'code' => 1060,
                'name' => 'Securities'
            ],
            [
                'id' => 101,
                'group' => 5,
                'oby' => 8,
                'code_category_id' => 48,
                'code' => 1090,
                'name' => 'Fund transfer account'
            ],
            [
                'id' => 102,
                'group' => 5,
                'oby' => 9,
                'code_category_id' => 49,
                'code' => 1100,
                'name' => 'Accounts receivable trade and services'
            ],
            [
                'id' => 103,
                'group' => 5,
                'oby' => 10,
                'code_category_id' => 49,
                'code' => 1105,
                'name' => 'Accounts receivable EUR'
            ],
            [
                'id' => 104,
                'group' => 5,
                'oby' => 11,
                'code_category_id' => 50,
                'code' => 1120,
                'name' => 'Employee account revceivables'
            ],
            [
                'id' => 105,
                'group' => 5,
                'oby' => 12,
                'code_category_id' => 50,
                'code' => 1140,
                'name' => 'Advances and loans'
            ],
            [
                'id' => 106,
                'group' => 5,
                'oby' => 13,
                'code_category_id' => 50,
                'code' => 1170,
                'name' => 'Input tax on cost of material and services'
            ],
            [
                'id' => 107,
                'group' => 5,
                'oby' => 14,
                'code_category_id' => 50,
                'code' => 1171,
                'name' => 'Input tax on investments and other '
            ],
            [
                'id' => 108,
                'group' => 5,
                'oby' => 15,
                'code_category_id' => 50,
                'code' => 1190,
                'name' => 'Other short-term receivables'
            ],
            [
                'id' => 109,
                'group' => 5,
                'oby' => 16,
                'code_category_id' => 50,
                'code' => 1192,
                'name' => 'Advance payments'
            ],
            [
                'id' => 110,
                'group' => 5,
                'oby' => 17,
                'code_category_id' => 51,
                'code' => 1300,
                'name' => 'Prepaid expenses'
            ],
            [
                'id' => 111,
                'group' => 5,
                'oby' => 18,
                'code_category_id' => 51,
                'code' => 1310,
                'name' => 'Insurance'
            ],
            [
                'id' => 112,
                'group' => 5,
                'oby' => 19,
                'code_category_id' => 51,
                'code' => 1320,
                'name' => 'Annual Subscripton 1'
            ],
            [
                'id' => 113,
                'group' => 5,
                'oby' => 20,
                'code_category_id' => 51,
                'code' => 1330,
                'name' => 'Annual Subscripton 2'
            ],
            [
                'id' => 114,
                'group' => 6,
                'oby' => 21,
                'code_category_id' => 52,
                'code' => 1400,
                'name' => 'Securities'
            ],
            [
                'id' => 115,
                'group' => 6,
                'oby' => 22,
                'code_category_id' => 52,
                'code' => 1409,
                'name' => 'VA Securities'
            ],
            [
                'id' => 116,
                'group' => 6,
                'oby' => 23,
                'code_category_id' => 52,
                'code' => 1410,
                'name' => 'Securities to market value'
            ],
            [
                'id' => 117,
                'group' => 6,
                'oby' => 24,
                'code_category_id' => 52,
                'code' => 1403,
                'name' => 'Bonds'
            ],
            [
                'id' => 118,
                'group' => 6,
                'oby' => 25,
                'code_category_id' => 52,
                'code' => 1440,
                'name' => 'Loans'
            ],
            [
                'id' => 119,
                'group' => 6,
                'oby' => 26,
                'code_category_id' => 52,
                'code' => 1441,
                'name' => 'Mortgages'
            ],
            [
                'id' => 120,
                'group' => 6,
                'oby' => 27,
                'code_category_id' => 53,
                'code' => 1480,
                'name' => 'Holdings'
            ],
            [
                'id' => 121,
                'group' => 6,
                'oby' => 28,
                'code_category_id' => 53,
                'code' => 1489,
                'name' => 'VA Holdings'
            ],
            [
                'id' => 122,
                'group' => 6,
                'oby' => 29,
                'code_category_id' => 54,
                'code' => 1510,
                'name' => 'Movable property, furnishings'
            ],
            [
                'id' => 123,
                'group' => 6,
                'oby' => 30,
                'code_category_id' => 54,
                'code' => 1520,
                'name' => 'Office machinery, computers, communication'
            ],
            [
                'id' => 124,
                'group' => 6,
                'oby' => 31,
                'code_category_id' => 54,
                'code' => 1530,
                'name' => 'Vehicles'
            ],
            [
                'id' => 125,
                'group' => 6,
                'oby' => 32,
                'code_category_id' => 55,
                'code' => 1700,
                'name' => 'Patents'
            ],
            [
                'id' => 126,
                'group' => 6,
                'oby' => 33,
                'code_category_id' => 55,
                'code' => 1701,
                'name' => 'Know-how'
            ],
            [
                'id' => 127,
                'group' => 6,
                'oby' => 34,
                'code_category_id' => 55,
                'code' => 1720,
                'name' => 'Licenses'
            ],
            [
                'id' => 128,
                'group' => 6,
                'oby' => 35,
                'code_category_id' => 55,
                'code' => 1770,
                'name' => 'Goodwill'
            ],
            [
                'id' => 129,
                'group' => 6,
                'oby' => 36,
                'code_category_id' => 56,
                'code' => 1850,
                'name' => 'Share capital, not paid in'
            ],
            [
                'id' => 130,
                'group' => 7,
                'oby' => 37,
                'code_category_id' => 57,
                'code' => 2000,
                'name' => 'Payables (Accounts payable)'
            ],
            [
                'id' => 131,
                'group' => 7,
                'oby' => 38,
                'code_category_id' => 57,
                'code' => 2005,
                'name' => 'Payables EUR'
            ],
            [
                'id' => 132,
                'group' => 7,
                'oby' => 39,
                'code_category_id' => 57,
                'code' => 2030,
                'name' => 'Advance payments from customers'
            ],
            [
                'id' => 133,
                'group' => 7,
                'oby' => 40,
                'code_category_id' => 58,
                'code' => 2100,
                'name' => 'Due to banks, short-term'
            ],
            [
                'id' => 134,
                'group' => 7,
                'oby' => 41,
                'code_category_id' => 58,
                'code' => 2120,
                'name' => 'Financial leasing payables'
            ],
            [
                'id' => 135,
                'group' => 7,
                'oby' => 42,
                'code_category_id' => 58,
                'code' => 2140,
                'name' => 'Other interest-bearing liabilities'
            ],
            [
                'id' => 136,
                'group' => 7,
                'oby' => 43,
                'code_category_id' => 58,
                'code' => 2160,
                'name' => 'Shareholder liabilities'
            ],
            [
                'id' => 137,
                'group' => 7,
                'oby' => 44,
                'code_category_id' => 59,
                'code' => 2200,
                'name' => 'Turnover tax'
            ],
            [
                'id' => 138,
                'group' => 7,
                'oby' => 45,
                'code_category_id' => 59,
                'code' => 2201,
                'name' => 'VAT payment account'
            ],
            [
                'id' => 139,
                'group' => 7,
                'oby' => 46,
                'code_category_id' => 59,
                'code' => 2210,
                'name' => 'Other short-term payables'
            ],
            [
                'id' => 140,
                'group' => 7,
                'oby' => 47,
                'code_category_id' => 60,
                'code' => 2270,
                'name' => 'Due to BVG'
            ],
            [
                'id' => 141,
                'group' => 7,
                'oby' => 48,
                'code_category_id' => 60,
                'code' => 2271,
                'name' => 'Due to AHV/ALV'
            ],
            [
                'id' => 142,
                'group' => 7,
                'oby' => 49,
                'code_category_id' => 60,
                'code' => 2272,
                'name' => 'Due to FAK'
            ],
            [
                'id' => 143,
                'group' => 7,
                'oby' => 50,
                'code_category_id' => 60,
                'code' => 2273,
                'name' => 'Due to UVG'
            ],
            [
                'id' => 144,
                'group' => 7,
                'oby' => 51,
                'code_category_id' => 60,
                'code' => 2274,
                'name' => 'Due to KVG'
            ],
            [
                'id' => 145,
                'group' => 7,
                'oby' => 52,
                'code_category_id' => 60,
                'code' => 2279,
                'name' => 'Tax at source due'
            ],
            [
                'id' => 146,
                'group' => 7,
                'oby' => 53,
                'code_category_id' => 60,
                'code' => 2280,
                'name' => 'Transitory payroll account'
            ],
            [
                'id' => 147,
                'group' => 8,
                'oby' => 54,
                'code_category_id' => 61,
                'code' => 2300,
                'name' => 'Unpaid expenses'
            ],
            [
                'id' => 148,
                'group' => 8,
                'oby' => 55,
                'code_category_id' => 61,
                'code' => 2330,
                'name' => 'Short-term provisions restoration and repairs'
            ],
            [
                'id' => 149,
                'group' => 8,
                'oby' => 56,
                'code_category_id' => 62,
                'code' => 2400,
                'name' => 'Bank liabilities'
            ],
            [
                'id' => 150,
                'group' => 8,
                'oby' => 57,
                'code_category_id' => 62,
                'code' => 2420,
                'name' => 'Liabilities from financial leasing contracts'
            ],
            [
                'id' => 151,
                'group' => 8,
                'oby' => 58,
                'code_category_id' => 62,
                'code' => 2450,
                'name' => 'Loans'
            ],
            [
                'id' => 152,
                'group' => 8,
                'oby' => 59,
                'code_category_id' => 62,
                'code' => 2451,
                'name' => 'Mortgage on commercial property'
            ],
            [
                'id' => 153,
                'group' => 8,
                'oby' => 60,
                'code_category_id' => 63,
                'code' => 2500,
                'name' => 'Loans'
            ],
            [
                'id' => 154,
                'group' => 8,
                'oby' => 61,
                'code_category_id' => 64,
                'code' => 2600,
                'name' => 'Provisions'
            ],
            [
                'id' => 155,
                'group' => 8,
                'oby' => 62,
                'code_category_id' => 64,
                'code' => 2630,
                'name' => 'Provisions for warranties'
            ],
            [
                'id' => 156,
                'group' => 8,
                'oby' => 63,
                'code_category_id' => 64,
                'code' => 2640,
                'name' => 'Provisions for deferred taxes'
            ],
            [
                'id' => 157,
                'group' => 9,
                'oby' => 64,
                'code_category_id' => 65,
                'code' => 2800,
                'name' => 'Share capital'
            ],
            [
                'id' => 158,
                'group' => 9,
                'oby' => 65,
                'code_category_id' => 66,
                'code' => 2900,
                'name' => 'Legal capital reserves'
            ],
            [
                'id' => 159,
                'group' => 9,
                'oby' => 66,
                'code_category_id' => 66,
                'code' => 2930,
                'name' => 'Provisions for own shares of capital'
            ],
            [
                'id' => 160,
                'group' => 9,
                'oby' => 67,
                'code_category_id' => 66,
                'code' => 2940,
                'name' => 'Revaluation reserve'
            ],
            [
                'id' => 161,
                'group' => 9,
                'oby' => 68,
                'code_category_id' => 66,
                'code' => 2950,
                'name' => 'Legal reserve Retained earnings'
            ],
            [
                'id' => 162,
                'group' => 9,
                'oby' => 69,
                'code_category_id' => 66,
                'code' => 2960,
                'name' => 'Optional reserves on earnings'
            ],
            [
                'id' => 163,
                'group' => 9,
                'oby' => 70,
                'code_category_id' => 66,
                'code' => 2970,
                'name' => 'Earned Surplus carr. forward or loss carried forward'
            ],
            [
                'id' => 164,
                'group' => 9,
                'oby' => 71,
                'code_category_id' => 66,
                'code' => 2979,
                'name' => 'Annual profit or annual loss'
            ],
            [
                'id' => 165,
                'group' => 9,
                'oby' => 72,
                'code_category_id' => 66,
                'code' => 2980,
                'name' => 'Treasury shares'
            ],
        ];

        DB::table('codes')->insert($codes);

        $update = [
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('codes')->update($update);
    }
}
