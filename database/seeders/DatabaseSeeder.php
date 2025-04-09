<?php

use App\Models\User;
use App\Models\MisStaff;
use App\Models\Category; // <-- Add this line
use App\Models\TaskList;
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


    // Define categories with their tasks
    $categoriesWithTasks = [
      'Computer/Laptop/Printer' => [
        'Set up a new computer or laptop',
        'Install a printer driver',
        'Replace printer ink or toner',
        'Fix a paper jam in the printer',
        'Perform basic troubleshooting when the device won\'t turn on',
      ],
      'Network' => [
        'Set up and configure a Wi-Fi router',
        'Check and fix network cable connections',
        'Assist users in connecting to Wi-Fi',
        'Restart the modem or router',
        'Monitor network status or connectivity',
      ],
      'Software' => [
        'Install or update software (e.g., MS Office, antivirus)',
        'Remove unneeded software',
        'Configure email accounts on Outlook or Gmail',
        'Help reset forgotten passwords',
        'Perform basic virus scan and cleanup',
      ],
      'Telephone' => [
        'Set up an office phone',
        'Check if the line is working',
        'Connect the phone to the network if needed',
        'Assist with voicemail setup',
        'Troubleshoot no dial tone or static issues',
      ],
    ];

    // Loop through and seed
    foreach ($categoriesWithTasks as $categoryName => $tasks) {
      $category = Category::create(['name' => $categoryName]);

      foreach ($tasks as $task) {
        TaskList::create([
          'category_id' => $category->id,
          'task' => $task,
        ]);
      }
    }


    
  }
}
