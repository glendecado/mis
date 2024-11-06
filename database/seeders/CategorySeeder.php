<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //////////
        $clp = Category::create([
            'name' => 'Computer/Laptop/Printer'
        ]);

        $clp->save();


        //////////
        $net = Category::create([
            'name' => 'Network'
        ]);

        $net->save();


        //////////
        $soft = Category::create([
            'name' => 'Software'
        ]);

        $soft->save();

        //////////
        $tel = Category::create([
            'name' => 'Telephone'
        ]);

        $tel->save();
    }
}
