<?php

declare(strict_types=1);

namespace LaravelPayHere\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelPayHere\PayHere;

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

        $order = PayHere::$orderModel::findOrFail($request->order_id);

        return view('payhere::return', [
            'total' => $order->total,
        ]);
    }
}
