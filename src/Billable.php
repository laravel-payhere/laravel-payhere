<?php

namespace LaravelPayHere;

use LaravelPayHere\Concerns\HandleCheckout;
use LaravelPayHere\Concerns\ManagesPayments;
use LaravelPayHere\Concerns\ManagesSubscriptions;

trait Billable
{
    use HandleCheckout;
    use ManagesPayments;
    use ManagesSubscriptions;
}
