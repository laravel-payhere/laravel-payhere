<?php

declare(strict_types=1);

namespace PayHere\Filament\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use PayHere\Filament\Resources\PaymentResource\PaymentResource;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}
