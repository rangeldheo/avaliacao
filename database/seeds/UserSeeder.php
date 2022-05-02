<?php

use App\Services\ActivationServices;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->addHour(1);
        DB::table('users')->insert([
            [
                'name' => 'Rangel Dheo',
                'email' => 'rangeldheo@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'), // password 12345678
                'remember_token' => Hash::make(Str::random(10)),
                'activation_hash' =>  ActivationServices::hashGenerate('rangeldheo@gmail.com'),
                'activation_expires' => $now,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status' => 1
            ],
        ]);
        factory(User::class, 20)->create();
    }
}