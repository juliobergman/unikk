<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ChartCollectionSeeder::class,
            ChartSeeder::class,
            PeccSeeder::class,
            ReportSchemaSeeder::class,
            ContactSeeder::class,
            FinancialFieldsSeeder::class,
            FinancialReportSeeder::class,
            FinancialSchemaSeeder::class,
            FinancialSchemaDataSeeder::class,
            FinancialDataSeeder::class,
        ]);
    }
}
