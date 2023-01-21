<?php

namespace Database\Factories;

use App\Models\Events;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventTime>
 */
class EventTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "event_id"=> Events::query()->inRandomOrder()->first()->value('id'),
            "eventTime"=>$this->faker->time("H:i"),
            "eventDate"=>$this->faker->date('Y-m-d'),
            "status"=> 1
        ];
    }
}
