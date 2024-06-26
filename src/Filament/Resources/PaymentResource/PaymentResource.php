<?php

namespace Dasundev\PayHere\Filament\Resources\PaymentResource;

use Dasundev\PayHere\Models\Payment;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $slug = 'payments';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),

                TextColumn::make('user.name'),

                TextColumn::make('order_id')
                    ->searchable(),

                TextColumn::make('subscription_id')
                    ->searchable(),

                TextColumn::make('payhere_amount')
                    ->money(),

                TextColumn::make('captured_amount')
                    ->money(),

                TextColumn::make('payhere_currency'),

                TextColumn::make('payment_id')
                    ->searchable(),

                TextColumn::make('status_code'),

                TextColumn::make('status_message')
                    ->label('Payment gateway message'),

                TextColumn::make('method')
                    ->label('Payment method'),

                TextColumn::make('card_holder_name'),

                TextColumn::make('card_no'),

                TextColumn::make('card_expiry'),

                IconColumn::make('recurring')
                    ->label('Recurring payment')
                    ->boolean(),

                TextColumn::make('message_type')
                    ->label('Status message'),

                TextColumn::make('item_recurrence')
                    ->label('How often it charges'),

                TextColumn::make('item_duration')
                    ->label('How long it charges'),

                TextColumn::make('item_rec_status')
                    ->label('Recurring subscription status'),

                TextColumn::make('item_rec_date_next')
                    ->label('Next recurring installment'),

                TextColumn::make('item_rec_install_paid')
                    ->label('Successful recurring installments'),

                TextColumn::make('custom_1'),

                TextColumn::make('custom_2'),

                TextColumn::make('created_at')
                    ->date(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
