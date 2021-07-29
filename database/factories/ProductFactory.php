<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\Fakecar;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Fakecar($this->faker));

        return [
            "name" => $this->faker->vehicle, 
            "price" => rand(99, 999),
            "status" => "active"
        ];
    }
}
