<?php

declare(strict_types=1);

namespace PayHere\Filament\Resources\SubscriptionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use PayHere\Filament\Resources\SubscriptionResource\SubscriptionResource;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;
}
