<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PayHere\PayHere;

class Checkout extends Controller
{
    public function __invoke(Request $request)
    {
        return PayHere::builder()
            ->amount(100)
            ->checkout();
    }
}
