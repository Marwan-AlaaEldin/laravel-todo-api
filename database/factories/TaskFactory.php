<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Category;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'done']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'reminder_sent_at' => null,
        ];
    }
}
