<?php

use App\Models\User;
use App\Models\MisStaff;
use App\Models\Faculty;
use App\Models\TechnicalStaff;
use App\Models\Category; // <-- Add this line
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
  public function run()
  {
    Cache::flush();

    if (!User::where('role', 'Mis Staff')->exists()) {
      $user = User::factory()->create([
        'role' => 'Mis Staff',
        'password' => bcrypt('mis'),
        'email' => 'mis@mis',
        'status' => 'active',
        'name' => 'mis',
      ]);

      MisStaff::factory()->create([
        'misStaff_id' => $user->id
      ]);
    }



    // Seeding categories
    Category::create(['name' => 'Computer/Laptop/Printer']);
    Category::create(['name' => 'Network']);
    Category::create(['name' => 'Software']);
    Category::create(['name' => 'Telephone']);
  }
}
