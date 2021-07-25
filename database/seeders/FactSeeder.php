<?php

namespace Database\Seeders;

use Carbon\CarbonPeriod;
use App\Models\finance\Fact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class FactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $csec = new Sequence(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93);

        $dates = [
            '2021-01-15',
            // '2021-02-15',
            // '2021-03-15',
            // '2021-04-15',
            // '2021-05-15',
            // '2021-06-15',
            // '2021-07-15',
            // '2021-08-15',
            // '2021-09-15',
            // '2021-10-15',
            // '2021-11-15',
            // '2021-12-15',
        ];

        Fact::factory(1000)->create();
        // foreach ($dates as $value) {
        //     Fact::factory(93)
        //     ->state(
        //         [
        //             'date' => $value,
        //             'code_id' => $csec,
        //             'report_id' => new Sequence(1,2),
        //             'report_id' => 1,
        //             'company_id' => 1,
        //             'user_id' => 1,
        //             'amount' => 100,
        //         ],
        //     )->create();
        // }
    }
}
