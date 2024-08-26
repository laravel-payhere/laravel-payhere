<?php

declare(strict_types=1);

namespace LaravelPayHere\Filament\Resources\SubscriptionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use LaravelPayHere\Filament\Resources\SubscriptionResource\SubscriptionResource;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;
}
