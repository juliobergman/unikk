<?php

namespace App\Listeners;

use App\Models\Membership;
use App\Models\CompanyData;
use App\Events\companyCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

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
            'logo' => '/factory/stock/company-logo.jpg'
        ]);
        Membership::create([
            'user_id' => $event->company->user_id,
            'company_id' => $event->company->id,
            'role' => 'admin'
        ]);
    }
}
