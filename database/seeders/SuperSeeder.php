<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Super;
use Illuminate\Support\Facades\Hash;

class SuperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = new Super;
        $super->name = "Super";
        $super->email = "superadmin@gmail.com";
        $super->password = Hash::make("Superadmin1");
        $super->save();
    }
}
