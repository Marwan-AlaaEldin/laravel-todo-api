<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $categories = Category::where('user_id', $user->id)->get();

            foreach ($categories as $category) {
                Task::factory(5)->create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}