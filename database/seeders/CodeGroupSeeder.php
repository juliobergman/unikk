<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $groups = [
            ['id' => 1, 'name' => 'Gross Profit'],
            ['id' => 2, 'name' => 'Operative Income'],
            ['id' => 3, 'name' => 'Earning Before Taxes'],
            ['id' => 4, 'name' => 'Net Income'],
            ['id' => 5, 'name' => 'EBIT'],
            ['id' => 6, 'name' => 'EBITDA'],
        ];

        DB::table('code_groups')->insert($groups);
    }
}
