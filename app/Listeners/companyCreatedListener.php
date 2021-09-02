<?php

namespace App\Listeners;

use App\Models\Settings;
use App\Models\Membership;
use App\Models\CompanyData;
use App\Events\companyCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\finance\EtlRatioController;
use App\Http\Controllers\finance\EtlIncomeController;
use App\Http\Controllers\finance\EtlBalanceController;

class companyCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  companyCreated  $event
     * @return void
     */
    public function handle(companyCreated $event)
    {
        CompanyData::create([
            'company_id' => $event->company->id,
            'country' => $event->country,
            'logo' => '/factory/stock/company-logo.jpg'
        ]);
        Membership::create([
            'user_id' => $event->company->user_id,
            'company_id' => $event->company->id,
            'role' => 'admin'
        ]);
        // Settings
        $settings = [
            [
                'company_id' => $event->company->id,
                'name' => 'Effective Tax Rate',
                'type' => 'float',
                'category' => 'financial',
                'selector' => 'financial_ratio',
                'value' => 0,
            ],
            [
                'company_id' => $event->company->id,
                'name' => 'Number of shares',
                'type' => 'float',
                'category' => 'financial',
                'selector' => 'financial_ratio',
                'value' => 0,
            ]
        ];

        DB::table('settings')->insert($settings);



        // Controllers Clones
        $etl_income = new EtlIncomeController;
        $etl_balance = new EtlBalanceController;
        $etl_ratio = new EtlRatioController;

        $request = new \Illuminate\Http\Request();
        $request->replace([
            'year' => date('Y'),
            'company' => $event->company->id,
        ]);

        $etl_income->extract($request);
        $etl_balance->extract($request);
        $etl_ratio->extract($request);

    }
}
