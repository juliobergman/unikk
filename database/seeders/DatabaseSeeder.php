<?php

namespace Database\Seeders;

use App\Models\ResCountry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('app:PopulateDateDimensionsTableCommand');

        $this->call([
            UserSeeder::class,
            ResCountrySeeder::class,
            ResCurrencySeeder::class,
            ChartCollectionSeeder::class,
            ChartSeeder::class,
            PeccSeeder::class,
            ContactSeeder::class,
            CodeGroupSeeder::class,
            CodeCategorySeeder::class,
            CodeSeeder::class,
            ReportSeeder::class,
            FactSeeder::class,
        ]);

    }
}
