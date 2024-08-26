<?php

namespace LaravelPayHere\Filament\Resources\PaymentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use LaravelPayHere\Filament\Resources\PaymentResource\PaymentResource;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}
