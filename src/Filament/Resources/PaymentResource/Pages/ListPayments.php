<?php

namespace Dasundev\PayHere\Filament\Resources\PaymentResource\Pages;

use Dasundev\PayHere\Filament\Resources\PaymentResource\PaymentResource;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}
