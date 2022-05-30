<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorkTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "date" => $this->faker->date("Y-m-d"),
            "work_start" => $this->faker->time("H:i:s"),
            "work_end" => $this->faker->time("H:i:s")
        ];
    }
}
