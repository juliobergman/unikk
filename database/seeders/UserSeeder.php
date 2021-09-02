<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\UserData;
use App\Models\Membership;
use App\Models\CompanyData;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Sequence;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'First Admin',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make(env('USER_PASSWORD')),
            'temptoken' => Str::random(10),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('user_data')->insert([
            'user_id' => 1,
            'profile_pic' => '/factory/stock/avatar-logo.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('companies')->insert([
            'id' => 1,
            'user_id' => 1,
            'company_id' => null,
            'currency_id' => 2,
            'name' => 'Unikk Ventures AG',
            'type' => 'active',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('company_data')->insert([
            'company_id' => 1,
            'logo' => '/factory/stock/unikk-logo.jpg',
            'country' => 'ch',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('memberships')->insert([
            'user_id' => 1,
            'company_id' => '1',
            'job_title' => 'System Admin',
            'role' => 'admin',
            'default' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

    }
}
