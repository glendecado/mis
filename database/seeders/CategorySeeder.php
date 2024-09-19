<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //////////
        $clp = Category::create([
            'category' => 'Computer/Laptop/Printer'
        ]);

        $clp->save();


        //////////
        $net = Category::create([
            'category' => 'Network'
        ]);

        $net->save();


        //////////
        $soft = Category::create([
            'category' => 'Software'
        ]);

        $soft->save();

        //////////
        $tel = Category::create([
            'category' => 'Telephone'
        ]);

        $tel->save();


        
    }
}
