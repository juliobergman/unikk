<?php

namespace Database\Seeders;

use App\Models\ChartCollection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chart_collections')->insert([
            'user_id' => 1,
            'company_id'=> 1,
            'name' => 'My First Collection',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ChartCollection::factory(10)->create();
    }
}
