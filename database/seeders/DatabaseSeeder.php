<?php

use App\Models\User;
use App\Models\MisStaff;
use App\Models\Faculty;
use App\Models\TechnicalStaff;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run()
  {

    if (!User::where('role', 'Mis Staff')->exists()) {
      // Create one user for the Mis Staff
      $user = User::factory()->create([
        'role' => 'Mis Staff',
        'password' => bcrypt('mis'), // Hash the password for security
        'email' => 'mis@mis', // Ensure this user is a Mis Staff
        'name' => 'mis', // Ensure this user is a Mis Staff
      ]);

      // Create one MisStaff instance associated with the created user
      MisStaff::factory()->create([
        'misStaff_id' => $user->id
      ]);
    }


    // Create multiple Faculty users
    $facultyUsers = User::factory(5)->create([
      'role' => 'Faculty' // Create 5 faculty users
    ]);

    foreach ($facultyUsers as $facultyUser) {
      Faculty::factory()->create([
        'faculty_id' => $facultyUser->id
      ]);
    }

    // Create multiple Technical Staff users
    $technicalStaffUsers = User::factory(5)->create([
      'role' => 'Technical Staff' // Create 5 technical staff users
    ]);

    foreach ($technicalStaffUsers as $technicalStaffUser) {
      TechnicalStaff::factory()->create([
        'technicalStaff_id' => $technicalStaffUser->id
      ]);
    }
  }
}
