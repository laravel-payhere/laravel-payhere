<?php

namespace LaravelPayHere\Filament\Resources\PaymentResource\Pages;

use LaravelPayHere\Filament\Resources\PaymentResource\PaymentResource;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}
