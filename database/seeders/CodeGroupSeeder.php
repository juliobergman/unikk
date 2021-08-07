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
            ['id' => 1, 'type' => 'income', "oby" => 1, 'name' => 'Gross Profit'],
            ['id' => 2, 'type' => 'income', "oby" => 2, 'name' => 'Operative Income'],
            ['id' => 3, 'type' => 'income', "oby" => 3, 'name' => 'Earning Before Taxes'],
            ['id' => 4, 'type' => 'income', "oby" => 4, 'name' => 'Net Income'],
            ['id' => 5, 'type' => 'balance', "oby" => 1, 'name' => 'Total Current Assets'],
            ['id' => 6, 'type' => 'balance', "oby" => 2, 'name' => 'Total Fixed Assets'],
            ['id' => 7, 'type' => 'balance', "oby" => 3, 'name' => 'Total Short-term Liabilites'],
            ['id' => 8, 'type' => 'balance', "oby" => 4, 'name' => 'Total Long-Term Liabilites'],
            ['id' => 9, 'type' => 'balance', "oby" => 5, 'name' => 'Total Equity'],
        ];

        DB::table('code_groups')->insert($groups);
    }
}
