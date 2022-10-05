<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Null_;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name'  => 'Superadmin',
                'username' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'role'            => 'Superadmin'
            ],
            [
                'name'          => 'Admin',
                'username'      => 'admin',
                'email'          => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'role'          => 'Admin'
            ]
        ]);
    }
}
