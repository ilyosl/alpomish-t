<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KatokQrcodeModel>
 */
class KatokQrcodeModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "qrcode" => fake()->unique()->buildingNumber(),
            'price' => fake()->randomNumber(6),
            'time'=> 30,
            'startDate' => date('d.m.Y H:i:s', strtotime("now")),
            'finishDate' => date('d.m.Y H:i:s', strtotime("+30 minutes")),
            'status' => 0,
            'is_read' => 0,
            'sell_date' => date('d.m.Y H:i:s', strtotime("now"))
        ];
    }
}
