<?php

namespace Dasundev\PayHere;

use Dasundev\PayHere\Concerns\HandleCheckout;
use Dasundev\PayHere\Concerns\ManagesPayments;
use Dasundev\PayHere\Concerns\ManagesSubscriptions;

trait Billable
{
    use HandleCheckout;
    use ManagesPayments;
    use ManagesSubscriptions;
}
