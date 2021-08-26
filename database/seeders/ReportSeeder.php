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
                'name' => 'Forecast Income Statement',
                'type' => 'income',
                'af' => 'forecast'
            ],
            [
                'id' => 2,
                'name' => 'Actual Income Statement',
                'type' => 'income',
                'af' => 'actual'
            ],
            [
                'id' => 3,
                'name' => 'Forecast Balance Sheet',
                'type' => 'balance',
                'af' => 'forecast'
            ],
            [
                'id' => 4,
                'name' => 'Actual Balance Sheet',
                'type' => 'balance',
                'af' => 'actual'
            ],
            [
                'id' => 5,
                'name' => 'Forecast Ratio Panel',
                'type' => 'ratio',
                'af' => 'forecast'
            ],
            [
                'id' => 6,
                'name' => 'Actual Ratio Panel',
                'type' => 'ratio',
                'af' => 'actual'
            ],
        ];

        DB::table('reports')->insert($reports);
    }
}
