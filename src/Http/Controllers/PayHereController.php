<?php

declare(strict_types=1);

namespace PayHere\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PayHere\PayHere;

class PayHereController extends Controller
{
    /**
     * Handle PayHere return request.
     *
     * @return View
     */
    public function handleReturn(Request $request)
    {
        if (! $request->hasValidSignatureWhileIgnoring(['order_id'])) {
            abort(401);
        }

        return view('payhere::return');
    }
}
