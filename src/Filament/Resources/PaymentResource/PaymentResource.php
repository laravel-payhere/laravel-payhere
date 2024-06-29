<?php

namespace Dasundev\PayHere\Filament\Resources\PaymentResource;

use Dasundev\PayHere\Enums\PaymentMethod;
use Dasundev\PayHere\Enums\PaymentStatus;
use Dasundev\PayHere\Enums\RefundStatus;
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
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('payhere_amount')
                    ->label('Amount')
                    ->sortable()
                    ->searchable()
                    ->money(fn (Payment $payment) => $payment->payhere_currency),

                TextColumn::make('captured_amount')
                    ->sortable()
                    ->searchable()
                    ->money(fn (Payment $payment) => $payment->payhere_currency),

                IconColumn::make('recurring')
                    ->sortable()
                    ->boolean()
                    ->searchable(),

                TextColumn::make('status_code')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->searchable(),

                TextColumn::make('method')
                    ->label('Payment method')
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->formatStateUsing(fn (Payment $record) => match ($record->method) {
                        PaymentMethod::VISA => view('payhere::icons.visa'),
                        PaymentMethod::MASTER => view('payhere::icons.master'),
                        PaymentMethod::AMEX => view('payhere::icons.amex'),
                        default => $record->method
                    }),

                TextColumn::make('card_holder_name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('card_no')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('card_expiry')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status_message')
                    ->label('Payment gateway message')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('message_type')
                    ->label('Status message')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subscription_id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('item_recurrence')
                    ->label('How often it charges')
                    ->formatStateUsing(fn ($record) => Str::ucwords(strtolower($record->item_recurrence)))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('item_duration')
                    ->label('How long it charges')
                    ->formatStateUsing(fn ($record) => Str::ucwords(strtolower($record->item_duration)))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('item_rec_status')
                    ->label('Recurring subscription status')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('item_rec_date_next')
                    ->label('Next recurring installment')
                    ->date()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('item_rec_install_paid')
                    ->label('Successful recurring installments')
                    ->sortable()
                    ->searchable(),

                IconColumn::make('refunded')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('refund_reason')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('payhere_currency')
                    ->label('Currency')
                    ->searchable()
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->date()
                    ->searchable()
                    ->sortable(),
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

                SelectFilter::make('status_code')
                    ->label('Status')
                    ->options(PaymentStatus::class),

            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                Action::make('refund')
                    ->button()
                    ->color('danger')
                    ->hidden(fn (Payment $record) => ! $record->isRefundable())
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to refund this payment?')
                    ->form([
                        Textarea::make('reason'),
                    ])
                    ->action(fn (Payment $record, array $data) => static::refund($record, $data['reason'])),
            ])
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
