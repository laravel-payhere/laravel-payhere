<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PayHere\PayHere;

class Recurring extends Controller
{
    public function __invoke(Request $request)
    {
        return PayHere::builder()
            ->guest()
            ->title('Recurring Checkout Test')
            ->recurring(
                recurrence: '1 Month',
                duration: '1 Year'
            )
            ->amount(100)
            ->checkout();
    }
}
