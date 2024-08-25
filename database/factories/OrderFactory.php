<?php

namespace LaravelPayHere\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelPayHere\Models\Order;
use Workbench\App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total' => 1000,
        ];
    }

    protected static function newFactory(): OrderFactory
    {
        return new OrderFactory;
    }
}
