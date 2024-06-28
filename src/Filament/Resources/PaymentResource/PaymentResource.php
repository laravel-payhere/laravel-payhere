<?php

namespace Dasundev\PayHere\Filament\Resources\PaymentResource;

use Dasundev\PayHere\Enums\PaymentStatus;
use Dasundev\PayHere\Enums\RefundStatus;
use Dasundev\PayHere\Enums\SubscriptionStatus;
use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\Services\Contracts\PayHereService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $slug = 'payments';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_id')
                    ->label(__('Payment id'))
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable(),

                TextColumn::make('payhere_amount')
                    ->label(__('Amount'))
                    ->searchable()
                    ->money(fn (Payment $payment) => $payment->payhere_currency),

                TextColumn::make('captured_amount')
                    ->label(__('Captured amount'))
                    ->searchable()
                    ->money(fn (Payment $payment) => $payment->payhere_currency),

                IconColumn::make('recurring')
                    ->label(__('Recurring'))
                    ->boolean()
                    ->searchable(),

                TextColumn::make('status_code')
                    ->label(__('Status'))
                    ->badge()
                    ->searchable(),

                TextColumn::make('method')
                    ->label(__('Payment method'))
                    ->searchable(),

                TextColumn::make('card_holder_name')
                    ->searchable(),

                TextColumn::make('card_no')
                    ->searchable(),

                TextColumn::make('card_expiry')
                    ->searchable(),

                TextColumn::make('status_message')
                    ->label(__('Payment gateway message'))
                    ->searchable(),

                TextColumn::make('message_type')
                    ->label(__('Status message'))
                    ->searchable(),

                TextColumn::make('subscription_id')
                    ->searchable(),

                TextColumn::make('item_recurrence')
                    ->label(__('How often it charges'))
                    ->formatStateUsing(fn ($record) => Str::ucwords(strtolower($record->item_recurrence)))
                    ->searchable(),

                TextColumn::make('item_duration')
                    ->label(__('How long it charges'))
                    ->formatStateUsing(fn ($record) => Str::ucwords(strtolower($record->item_duration)))
                    ->searchable(),

                TextColumn::make('item_rec_status')
                    ->label(__('Recurring subscription status'))
                    ->searchable(),

                TextColumn::make('item_rec_date_next')
                    ->label(__('Next recurring installment'))
                    ->date()
                    ->searchable(),

                TextColumn::make('item_rec_install_paid')
                    ->label(__('Successful recurring installments'))
                    ->searchable(),

                IconColumn::make('refunded')
                    ->label(__('Refunded'))
                    ->boolean(),

                TextColumn::make('refund_reason')
                    ->label(__('Refund reason'))
                    ->searchable(),

                TextColumn::make('payhere_currency')
                    ->label(__('Currency'))
                    ->searchable()
                    ->badge(),

                TextColumn::make('created_at')
                    ->date()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Split::make([
                            DatePicker::make('from')
                                ->label(__('Created from')),
                            DatePicker::make('to')
                                ->label(__('Created until')),
                        ])
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

                SelectFilter::make('status_code')
                    ->label('Status')
                    ->options(PaymentStatus::class)

            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                Action::make('refund')
                    ->button()
                    ->hidden(fn (Payment $record) => ! $record->isRefundable())
                    ->requiresConfirmation()
                    ->modalDescription(__('Are you sure you want to refund this payment?'))
                    ->form([
                        Textarea::make('reason'),
                    ])
                    ->action(fn (Payment $record, array $data) => static::refund($record, $data['reason'])),
            ])
            ->defaultGroup('subscription_id')
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }

    public static function refund(Payment $payment, ?string $reason = null): void
    {
        $service = app(PayHereService::class);
        $payload = $service->refund($payment, $reason);

        $status = $payload['status'];
        $message = $payload['msg'];

        $notification = Notification::make()->title($message);

        if ($status === RefundStatus::REFUND_SUCCESS->value) {
            $notification->success()->send();
        } else {
            $notification->danger()->send();
        }
    }
}
