<?php

namespace LaravelPayHere\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelPayHere\Models\Item;
use LaravelPayHere\Models\Order;
use LaravelPayHere\Models\OrderItem;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $unitPrice = fake()->numberBetween(100, 1000);
        $unitQty = fake()->numberBetween(1, 10);
        $total = $unitPrice * $unitQty;

        return [
            'order_id' => Order::factory(),
            'purchasable_type' => Item::class,
            'purchasable_id' => Item::factory(),
            'unit_price' => $unitPrice,
            'unit_quantity' => $unitQty,
            'total' => $total,
        ];
    }

    protected static function newFactory(): OrderItemFactory
    {
        return new OrderItemFactory;
    }
}
