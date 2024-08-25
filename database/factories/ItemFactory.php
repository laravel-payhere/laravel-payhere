<?php

namespace LaravelPayHere\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelPayHere\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'price' => fake()->numberBetween(100, 1000),
        ];
    }
}
