<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Routing\Controller;
use PayHere\PayHere;

class Authorize extends Controller
{
    public function __invoke()
    {
        return PayHere::builder()
            ->guest()
            ->title('Test')
            ->authorize()
            ->amount(100)
            ->checkout();
    }
}
