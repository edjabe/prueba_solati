<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'nombre' => $this->faker->text($maxNbChars = 20),
            'descripcion' => $this->faker->text($maxNbChars = 20),
            'cantidad' => $this->faker->numberBetween($min = 10, $max = 500),
            'valor' => $this->faker->numberBetween($min = 100, $max = 500),
            'moneda' => $this->faker->locale(),
            'category_id' =>Category::inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            'updated_at' => $this->faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
        ];
    }
}
