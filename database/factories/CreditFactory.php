<?php

namespace Database\Factories;

use App\Models\Credit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Credit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from' => $this->faker->name,
            'user_id' => User::all('id')->random(),
            'note' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(1000, 10000)
        ];
    }
}
