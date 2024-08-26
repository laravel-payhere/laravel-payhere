<?php

namespace LaravelPayHere\Filament\Resources\SubscriptionResource;

use LaravelPayHere\Enums\SubscriptionStatus;
use LaravelPayHere\Models\Subscription;
use LaravelPayHere\Services\Contracts\PayHereService;
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
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
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
                    ->options(SubscriptionStatus::class)
                    ->default(SubscriptionStatus::Active->value),
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
