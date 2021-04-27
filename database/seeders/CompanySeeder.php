<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Membership;
use App\Models\CompanyData;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Membership::factory(10)->create();
    }
}
