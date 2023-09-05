<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = $this->faker->dateTime();
        return [
            'todo' => $this->faker->asciify('********************'),
            'description' => $this->faker->asciify('********************************************'),
            'expireAt' => $createdAt->modify("+" . rand(1, 30) . " days")->format("Y-m-d H:i:s"),
            'userId' => rand(1, 50)
        ];
    }
}
