<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsModel>
 */
class NewsModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=>ucfirst($this->faker->words(4, true)),
            'short_text'=>$this->faker->text,
            'desc'=>$this->faker->text,
            'status'=>1,
            'image' => $this->faker->imageUrl(342, 210, null, false)
        ];
    }
}
