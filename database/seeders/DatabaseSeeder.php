<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // عمل 3 users وهميين
        User::factory(3)->create();

        $this->call([
            CategorySeeder::class,
            TaskSeeder::class,
        ]);
    }
}