<?php

namespace LaravelPayHere\Concerns;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

trait HandleCheckout
{
    use CheckoutFormData;

    /**
     * The amount of the transaction.
     */
    private ?float $amount = null;

    /**
     * Initiate the checkout process.
     *
     * @param  float  $amount
     * @return \Illuminate\Contracts\View\View
     */
    public function checkout(float $amount): View
    {
        $this->amount = $amount;
        
        return view('payhere::checkout', [
            'data' => $this->getFormData(),
        ]);
    }
}
