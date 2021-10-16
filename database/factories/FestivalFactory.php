<?php

namespace Database\Factories;

use App\Models\Festival;
use Illuminate\Database\Eloquent\Factories\Factory;

class FestivalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Festival::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'start_at' => now(),
            'end_at' => date('Y-m-d H:i:s', strtotime('+10 days', strtotime(date('Y-m-d H:i:s')))),
        ];
    }
}
