<?php

namespace Database\Seeders;

use App\Models\finance\Fact;
use Illuminate\Database\Seeder;

class FactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fact::factory(2000)->create();
    }
}
