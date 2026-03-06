<?php

namespace Database\Factories;

use App\Models\User;
use App\TaskPriority;
use App\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
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
            'title' => fake()->sentence(4),
            'description' => fake()->optional(0.7)->paragraph(),
            'status' => fake()->randomElement(TaskStatus::cases())->value,
            'priority' => fake()->randomElement(TaskPriority::cases())->value,
            'due_date' => fake()->optional(0.6)->dateTimeBetween('now', '+60 days')?->format('Y-m-d'),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => TaskStatus::PENDING->value, 'completed_at' => null]);
    }

    public function completed(): static
    {
        return $this->state(['status' => TaskStatus::COMPLETED->value, 'completed_at' => now()]);
    }

    public function highPriority(): static
    {
        return $this->state(['priority' => TaskPriority::HIGH->value]);
    }
}
