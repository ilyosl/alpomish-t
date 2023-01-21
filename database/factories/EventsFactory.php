<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title"=>$this->faker->words(4, true),
            "meta_title"=>$this->faker->words(4, true),
            "meta_keywords"=>$this->faker->words(4, true),
            "desc"=>$this->faker->text,
            "meta_desc"=>$this->faker->text,
            "status" => 1,
            "age_limit"=>"16+",
            'image' => $this->faker->imageUrl(342, 210, null, false),
            'cover' => $this->faker->imageUrl(342, 210, null, false),
        ];
    }
}
