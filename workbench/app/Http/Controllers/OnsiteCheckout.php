<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use PayHere\PayHere;

class OnsiteCheckout
{
    public function __invoke()
    {
        return view('workbench::onsite-checkout', [
            'order' => PayHere::order()
                ->guest()
                ->title('Onsite Checkout Test')
                ->amount(100)
                ->getOrder(),
        ]);
    }
}
