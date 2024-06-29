<?php

namespace Database\Seeders;

use App\Models\Faculty as ModelsFaculty;
use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Faculty extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'role' => 'Faculty',
            'password' => 'pass',
            'email' => 'test@test',
        ]);

        $faculty = ModelsFaculty::create([
            'faculty_id' => $user->id,
            'college' => 'tetst',
            'building' => 'tetst',
            'room' => 'tetst',
        ]);
        $faculty->User()->associate($user);
        $faculty->save();

        $req = Request::create([
            'faculty_id' => $user->id,
            'category' => 'ds',
            'concerns' => 'dsfdfs',
            'status' => 'waiting',
        ]);
    }
}
