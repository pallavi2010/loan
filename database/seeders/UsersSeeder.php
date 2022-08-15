<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::truncate(); 
        $users = [ 
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => 'admin12345',
                'is_admin' => '1',
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => 'user12345',
                'is_admin' => null,
            ]
        ];

        foreach($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'is_admin' => $user['is_admin'],
            ]);
        }
    }
}
