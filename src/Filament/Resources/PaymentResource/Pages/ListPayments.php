<?php

namespace Dasundev\PayHere\Filament\Resources\PaymentResource\Pages;

use Dasundev\PayHere\Filament\Resources\PaymentResource\PaymentResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}