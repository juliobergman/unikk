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
                    'sparkline' => 'no',
                    'oby' => 1,
                ],[
                    'id' => 2,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Book Value per Share",
                    'sparkline' => 'no',
                    'oby' => 2,
                ],[
                    'id' => 3,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Cash Ratio",
                    'sparkline' => 'no',
                    'oby' => 3,
                ],[
                    'id' => 4,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Current Assets",
                    'sparkline' => 'no',
                    'oby' => 4,
                ],[
                    'id' => 5,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Current Ratio",
                    'sparkline' => 'no',
                    'oby' => 5,
                ],[
                    'id' => 6,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Debt to Equity",
                    'sparkline' => 'no',
                    'oby' => 6,
                ],[
                    'id' => 7,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Depreciation and Amortization",
                    'sparkline' => 'no',
                    'oby' => 7,
                ],[
                    'id' => 8,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Direct Operational Cost",
                    'sparkline' => 'no',
                    'oby' => 8,
                ],[
                    'id' => 9,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Earning Before Taxes",
                    'sparkline' => 'no',
                    'oby' => 9,
                ],[
                    'id' => 10,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "EBIT",
                    'sparkline' => 'no',
                    'oby' => 10,
                ],[
                    'id' => 11,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "EBITDA",
                    'sparkline' => 'no',
                    'oby' => 11,
                ],[
                    'id' => 12,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "EBITDA (%)",
                    'sparkline' => 'no',
                    'oby' => 12,
                ],[
                    'id' => 13,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Equity",
                    'sparkline' => 'no',
                    'oby' => 13,
                ],[
                    'id' => 14,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Financial Cost",
                    'sparkline' => 'no',
                    'oby' => 14,
                ],[
                    'id' => 15,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Fixed Assets",
                    'sparkline' => 'no',
                    'oby' => 15,
                ],[
                    'id' => 16,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Gross Profit",
                    'sparkline' => 'no',
                    'oby' => 16,
                ],[
                    'id' => 17,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Gross Profit (%)",
                    'sparkline' => 'no',
                    'oby' => 17,
                ],[
                    'id' => 18,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Income",
                    'sparkline' => 'no',
                    'oby' => 18,
                ],[
                    'id' => 19,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Interest coverage",
                    'sparkline' => 'no',
                    'oby' => 19,
                ],[
                    'id' => 20,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Long-Term Liabilites",
                    'sparkline' => 'no',
                    'oby' => 20,
                ],[
                    'id' => 21,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Net Income",
                    'sparkline' => 'no',
                    'oby' => 21,
                ],[
                    'id' => 22,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Net Income (%)",
                    'sparkline' => 'no',
                    'oby' => 22,
                ],[
                    'id' => 23,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Non-company related expenditures/Income",
                    'sparkline' => 'no',
                    'oby' => 23,
                ],[
                    'id' => 24,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "NOPAT",
                    'sparkline' => 'no',
                    'oby' => 24,
                ],[
                    'id' => 25,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Operating Expenses",
                    'sparkline' => 'no',
                    'oby' => 25,
                ],[
                    'id' => 26,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Operative Income",
                    'sparkline' => 'no',
                    'oby' => 26,
                ],[
                    'id' => 27,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Other Income/Expenses",
                    'sparkline' => 'no',
                    'oby' => 27,
                ],[
                    'id' => 28,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Other Operational Cost",
                    'sparkline' => 'no',
                    'oby' => 28,
                ],[
                    'id' => 29,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Return on equity",
                    'sparkline' => 'no',
                    'oby' => 29,
                ],[
                    'id' => 30,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "ROIC",
                    'sparkline' => 'no',
                    'oby' => 30,
                ],[
                    'id' => 31,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Short-term Liabilites",
                    'sparkline' => 'no',
                    'oby' => 31,
                ],[
                    'id' => 32,
                    'chart' => 'barChart',
                    'report_type' => 'income',
                    'name' => "Taxes",
                    'sparkline' => 'no',
                    'oby' => 32,
                ],[
                    'id' => 33,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Total Assets",
                    'sparkline' => 'no',
                    'oby' => 33,
                ],[
                    'id' => 34,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Total Liabilities",
                    'sparkline' => 'no',
                    'oby' => 34,
                ],[
                    'id' => 35,
                    'chart' => 'barChart',
                    'report_type' => 'balance',
                    'name' => "Total Liabilities + Equity",
                    'sparkline' => 'no',
                    'oby' => 35,
                ],[
                    'id' => 36,
                    'chart' => 'barChart',
                    'report_type' => 'ratio',
                    'name' => "Working Capital",
                    'sparkline' => 'no',
                    'oby' => 36,
                ]
            ];

            DB::table('results')->insert($result);
    }
}
