<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(random_int(10, 20)),
            'link' => $this->faker->text(random_int(10, 40)),
            'rating' => $this->faker->numberBetween($min=1, $max=5),
            'status' => $this->faker->numberBetween($min=1, $max=2),
            'comment' => $this->faker->text(10),
            // 'ingredients' => \App\Models\Ingredient::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
