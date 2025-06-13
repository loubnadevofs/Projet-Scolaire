<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            // EnseignantSeeder::class, // معلق مؤقتاً
            // FormateurSeeder::class,  // معلق مؤقتاً
        ]);
    }
}
