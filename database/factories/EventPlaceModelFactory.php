<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventPlaceModel>
 */
class EventPlaceModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "place"=>$this->faker->numberBetween(1, 10),
            "row"=>$this->faker->numberBetween(1, 6),
            "block_name" => "A1",
            "event_id" => 1,
            "event_date"=> "2023-01-30",
            "event_time"=> "11:00",
            "price"=>50000,
            "status"=>1
        ];
    }
}
