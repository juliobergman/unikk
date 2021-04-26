<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyData;
use App\Models\Membership;
use App\Models\UserData;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'name' => 'Default',
            'email' => 'admin@mail.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'temptoken' => Str::random(10),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('user_data')->insert([
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'John Doe',
            'email' => 'demo@mail.com',
            'role' => 'editor',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'temptoken' => Str::random(10),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('user_data')->insert([
            'user_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        Membership::factory(3)
        ->create()
        ;

        Company::factory(3)
        ->has(CompanyData::factory())
        ->state(new Sequence(
        ['user_id' => 1],
        ['user_id' => 2],
        ))
        ->create();


        User::factory(15)
        ->has(UserData::factory())
        ->has(
            Membership::factory()
            ->state(new Sequence(
                ['company_id' => 1],
                ['company_id' => 2],
                ['company_id' => 3]
                ))
        )
        ->create();

        DB::table('memberships')
        ->where('id', 1)
        ->update([
            'user_id' => 1,
            'role' => 'admin',
            'company_id' => 1
        ]);
        DB::table('memberships')
        ->where('id', 2)
        ->update([
            'user_id' => 2,
            'role' => 'admin',
            'company_id' => 2
        ]);
        DB::table('memberships')
        ->where('id', 3)
        ->update([
            'user_id' => 1,
            'role' => 'admin',
            'company_id' => 3
        ]);

    }
}
