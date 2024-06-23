<?php

namespace Database\Seeders;

use App\Models\MisStaff as ModelsMisStaff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MisStaff extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'id' => 1,
            'name' => 'Mis Staff',
            'role' => 'Mis Staff',
            'email' => 'mis@email.com',
            'password' => 'mis'
        ]);

        $mis = ModelsMisStaff::create([
            'id' => 1,
            'user_id' => 1,
        ]);

        $mis->User()->associate($user);
        $mis->save();
    }
}
