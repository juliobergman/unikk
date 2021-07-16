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
                'type' => 'income'
            ],
            [
                'id' => 2,
                'name' => 'Forecast Income Statement',
                'type' => 'income'
            ],
        ];

        DB::table('reports')->insert($reports);
    }
}
