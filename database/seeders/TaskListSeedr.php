<?php

namespace Database\Seeders;

use App\Models\TaskList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskListSeedr extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskList::create(['category_id' => 1, 'task' => 'Diagnose slow performance']);
        TaskList::create(['category_id' => 1, 'task' => 'Remove malware/viruses']);
        TaskList::create(['category_id' => 1, 'task' => 'Fix blue screen errors']);
        TaskList::create(['category_id' => 1, 'task' => 'Resolve network connectivity issues']);
    }
}
