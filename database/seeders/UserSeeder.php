<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //when use model to make seeder it will put value to created_at & updated_at
        User::create([
            'name' => 'Israa Yousef',
            'email' => 'israa@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '0967874887'
        ]);
        DB::table('users')->insert([
            'name' => 'System Admin',
            'email' => 'sys@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '0967874888'
        ]);
    }
}
