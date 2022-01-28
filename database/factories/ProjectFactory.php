<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id'           => User::factory()->create()->id,
            'name'              => $this->faker->name,
            'short_description' => $this->faker->text(255),
            'description'       => $this->faker->text(1000),
            'image_path'        => $this->faker->imageUrl(),
            'forum_url'         => $this->faker->url,
            'license_key'       => $this->faker->text(255),
            'is_active'         => $this->faker->boolean,
        ];
    }
}
