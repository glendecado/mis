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
        // Create a user
        $user = User::create([
            'name' => 'Mis Staff',
            'role' => 'Mis Staff',
            'email' => 'mis@mis',
            'password' => bcrypt('mis'), // Always hash passwords
        ]);

        // Create a MisStaff record associated with the user
        $mis = ModelsMisStaff::create([
            'misStaff_id' => $user->id,
        ]);
        
        $mis->User()->associate($user);
        $mis->save();
    }
}
