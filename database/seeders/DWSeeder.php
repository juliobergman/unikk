<?php

namespace Database\Seeders;

use App\Http\Controllers\finance\EtlBalanceController;
use App\Http\Controllers\finance\EtlIncomeController;
use App\Http\Controllers\finance\EtlRatioController;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class DWSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Controllers Clones
        $etl_income = new EtlIncomeController;
        $etl_balance = new EtlBalanceController;
        $etl_ratio = new EtlRatioController;


        $request = new \Illuminate\Http\Request();
        $request->replace([
            'year' => 2021,
            'company' => 1,
        ]);

        $etl_income->extract($request);
        $etl_balance->extract($request);
        $etl_ratio->extract($request);

    }
}
