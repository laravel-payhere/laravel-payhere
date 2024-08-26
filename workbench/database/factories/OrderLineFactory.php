<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Order;
use Workbench\App\Models\OrderLine;
use Workbench\App\Models\Product;

class OrderLineFactory extends Factory
{
    protected $model = OrderLine::class;

    public function definition(): array
    {
        $unitPrice = fake()->numberBetween(100, 1000);
        $unitQty = fake()->numberBetween(1, 10);
        $total = $unitPrice * $unitQty;

        return [
            'order_id' => Order::factory(),
            'purchasable_type' => Product::class,
            'purchasable_id' => Product::factory(),
            'unit_price' => $unitPrice,
            'unit_quantity' => $unitQty,
            'total' => $total,
        ];
    }
}
