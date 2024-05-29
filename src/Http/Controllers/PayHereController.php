<?php

namespace Dasundev\PayHere\Http\Controllers;

use Dasundev\PayHere\PayHere;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

        $order = PayHere::$orderModel::find($request->order_id);

        return view('payhere::return', [
            'total' => $order->total
        ]);
    }
}
