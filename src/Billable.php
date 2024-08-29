<?php

declare(strict_types=1);

namespace PayHere;

use PayHere\Concerns\ManagesPayments;
use PayHere\Concerns\ManagesSubscriptions;

trait Billable
{
    use ManagesPayments;
    use ManagesSubscriptions;
}
