<?php

namespace Database\Factories;

use App\Models\Expenditure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenditureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expenditure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reason' => $this->faker->sentence,
            'note' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(10, 10000),
            'user_id' => User::all('id')->random()
        ];
    }
}
