<?php

namespace LaravelPayHere\Concerns;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

trait HandleCheckout
{
    use CheckoutFormData;

    /**
     * The order associated with this object.
     */
    protected ?Model $order = null;

    /**
     * Set a new order for checkout.
     */
    public function newOrder(Model $order): static
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Initiate the checkout process.
     */
    public function checkout(): View
    {
        return view('payhere::checkout', [
            'data' => $this->getFormData(),
        ]);
    }
}
