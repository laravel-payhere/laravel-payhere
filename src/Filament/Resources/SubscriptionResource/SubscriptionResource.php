<?php

namespace Dasundev\PayHere\Filament\Resources\SubscriptionResource;

use Dasundev\PayHere\Enums\RefundStatus;
use Dasundev\PayHere\Enums\SubscriptionStatus;
use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\Models\Subscription;
use Dasundev\PayHere\Services\Contracts\PayHereService;
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
                    ->searchable(),

                TextColumn::make('user.name')
                    ->searchable(),

                TextColumn::make('status')
                    ->searchable()
                    ->badge(),

                TextColumn::make('trial_ends_at')
                    ->searchable()
                    ->dateTime(),

                TextColumn::make('created_at')
                    ->searchable()
                    ->date(),

                TextColumn::make('ends_at')
                    ->searchable()
                    ->date(),
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
                Action::make('Cancel')
                    ->button()
                    ->visible(fn (Subscription $record) => $record->isCancellable())
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to cancel this subscription?')
                    ->action(fn (Subscription $record) => static::cancelSubscription($record))
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(SubscriptionStatus::class)
                    ->default(SubscriptionStatus::Active->value)
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
}
