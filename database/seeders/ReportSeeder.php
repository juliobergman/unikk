<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $reports = [
            [
                'id' => 1,
                'name' => 'Actual Income Statement',
                'type' => 'income',
                'tw' => 'actual'
            ],
            [
                'id' => 2,
                'name' => 'Forecast Income Statement',
                'type' => 'income',
                'tw' => 'forecast'
            ],
            [
                'id' => 3,
                'name' => 'Actual Balance Sheet',
                'type' => 'balance',
                'tw' => 'actual'
            ],
            [
                'id' => 4,
                'name' => 'Forecast Balance Sheet',
                'type' => 'balance',
                'tw' => 'forecast'
            ],
            [
                'id' => 5,
                'name' => 'Actual Ratio Panel',
                'type' => 'ratio',
                'tw' => 'actual'
            ],
            [
                'id' => 6,
                'name' => 'Forecast Ratio Panel',
                'type' => 'ratio',
                'tw' => 'forecast'
            ],
        ];

        DB::table('reports')->insert($reports);
    }
}
