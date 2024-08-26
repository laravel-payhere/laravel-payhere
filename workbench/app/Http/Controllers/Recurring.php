<?php

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workbench\App\Models\Order;
use Workbench\App\Models\OrderLine;

class Recurring extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::factory()
            ->has(OrderLine::factory()->count(2), 'lines')
            ->create();

        return $request
            ->user()
            ->newOrder($order)
            ->recurring(
                recurrence: '1 Month',
                duration: '1 Year'
            )
            ->checkout();
    }
}
