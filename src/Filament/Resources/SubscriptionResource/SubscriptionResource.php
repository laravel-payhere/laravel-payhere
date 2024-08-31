<?php

declare(strict_types=1);

namespace PayHere\Filament\Resources\SubscriptionResource;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Split;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use PayHere\Enums\SubscriptionStatus;
use PayHere\Models\Subscription;
use PayHere\Services\Contracts\PayHereService;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $slug = 'subscriptions';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payhere_subscription_id')
                    ->label('Subscription id')
                    ->copyable()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->default('Guest User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                TextColumn::make('trial_ends_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime(),

                TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime(),

                TextColumn::make('ends_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Split::make([
                            DatePicker::make('from')
                                ->label('Created from'),
                            DatePicker::make('to')
                                ->label('Created until'),
                        ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['to'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->columnSpan(2),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                Action::make('Retry')
                    ->button()
                    ->visible(fn (Subscription $record) => $record->isFailed())
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to retry this subscription?')
                    ->action(fn (Subscription $record) => static::retrySubscription($record)),
                Action::make('Cancel')
                    ->button()
                    ->color('danger')
                    ->visible(fn (Subscription $record) => $record->isCancellable())
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to cancel this subscription?')
                    ->action(fn (Subscription $record) => static::cancelSubscription($record)),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(SubscriptionStatus::class)
                    ->default([
                        SubscriptionStatus::Active->value,
                        SubscriptionStatus::Completed->value,
                        SubscriptionStatus::Cancelled->value,
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
        ];
    }

    private static function cancelSubscription(Subscription $subscription): void
    {
        $service = app(PayHereService::class);
        $payload = $service->cancelSubscription($subscription);

        $status = $payload['status'];
        $message = $payload['msg'];

        $notification = Notification::make()->title($message);

        if ($status === 1) {
            $notification->success()->send();

            return;
        }

        $notification->danger()->send();
    }

    private static function retrySubscription(Subscription $subscription): void
    {
        $service = app(PayHereService::class);
        $payload = $service->retrySubscription($subscription);

        $status = $payload['status'];
        $message = $payload['msg'];

        $notification = Notification::make()->title($message);

        if ($status === 1) {
            $notification->success()->send();

            return;
        }

        $notification->danger()->send();
    }
}
