<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = [
                [
                    'id' => 1,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Adjusted Equity",
                ],[
                    'id' => 2,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Book Value per Share",
                ],[
                    'id' => 3,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Cash Ratio",
                ],[
                    'id' => 4,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Current Assets",
                ],[
                    'id' => 5,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Current Ratio",
                ],[
                    'id' => 6,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Debt to Equity",
                ],[
                    'id' => 7,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Depreciation and Amortization",
                ],[
                    'id' => 8,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Direct Operational Cost",
                ],[
                    'id' => 9,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Earning Before Taxes",
                ],[
                    'id' => 10,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "EBIT",
                ],[
                    'id' => 11,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "EBITDA",
                ],[
                    'id' => 12,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "EBITDA (%)",
                ],[
                    'id' => 13,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Equity",
                ],[
                    'id' => 14,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Financial Cost",
                ],[
                    'id' => 15,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Fixed Assets",
                ],[
                    'id' => 16,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Gross Profit",
                ],[
                    'id' => 17,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Gross Profit (%)",
                ],[
                    'id' => 18,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Income",
                ],[
                    'id' => 19,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Interest coverage",
                ],[
                    'id' => 20,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Long-Term Liabilites",
                ],[
                    'id' => 21,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Net Income",
                ],[
                    'id' => 22,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Net Income (%)",
                ],[
                    'id' => 23,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Non-company related expenditures/Income",
                ],[
                    'id' => 24,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "NOPAT",
                ],[
                    'id' => 25,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Operating Expenses",
                ],[
                    'id' => 26,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Operative Income",
                ],[
                    'id' => 27,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Other Income/Expenses",
                ],[
                    'id' => 28,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Other Operational Cost",
                ],[
                    'id' => 29,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Return on equity",
                ],[
                    'id' => 30,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "ROIC",
                ],[
                    'id' => 31,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Short-term Liabilites",
                ],[
                    'id' => 32,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Taxes",
                ],[
                    'id' => 33,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Total Assets",
                ],[
                    'id' => 34,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Total Liabilities",
                ],[
                    'id' => 35,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Total Liabilities + Equity",
                ],[
                    'id' => 36,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Working Capital"
                ]
            ];

            DB::table('results')->insert($result);
    }
}
