<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = User::create([
            'name' => 'Souvik Nag',
            'email' => 'souvik@test.com',
            'password' => bcrypt('password'),
            'mobile' => '8335906101',
        ])->assignRole('admin');

        UserDetails::create([
            'user_id' => $data->id,
        ]);
    }
}
