<?php

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelPayHere\Models\Order;
use LaravelPayHere\Models\OrderItem;

class Checkout extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::factory()
            ->has(OrderItem::factory()->count(2), 'items')
            ->create();

        return $request
            ->user()
            ->newOrder($order)
            ->checkout();
    }
}
