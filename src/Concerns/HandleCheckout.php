<?php

declare(strict_types=1);

namespace LaravelPayHere\Concerns;

use Illuminate\Contracts\View\View;

trait HandleCheckout
{
    use CheckoutFormData;

    /**
     * Initiate the checkout process.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function checkout(): View
    {
        return view('payhere::checkout', [
            'data' => $this->getFormData(),
        ]);
    }
}
