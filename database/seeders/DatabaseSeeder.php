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
            SettingsSeeder::class,
            PeccSeeder::class,
            CodeGroupSeeder::class,
            CodeCategorySeederIncome::class,
            CodeCategorySeederBalance::class,
            CodeSeederIncome::class,
            CodeSeederBalance::class,
            ReportSeeder::class,
            ResultSeeder::class,
            DWSeeder::class,
        ]);

    }
}
