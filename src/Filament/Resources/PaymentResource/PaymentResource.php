<?php

namespace Dasundev\PayHere\Filament\Resources\PaymentResource;

use Dasundev\PayHere\Models\Payment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Split;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
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

                TextColumn::make('payhere_currency')
                    ->badge(),

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
                    ->label('How often it charges')
                    ->formatStateUsing(fn ($record) => Str::ucwords(strtolower($record->item_recurrence))),

                TextColumn::make('item_duration')
                    ->label('How long it charges')
                    ->formatStateUsing(fn ($record) => Str::ucwords(strtolower($record->item_duration))),

                TextColumn::make('item_rec_status')
                    ->label('Recurring subscription status'),

                TextColumn::make('item_rec_date_next')
                    ->label('Next recurring installment')
                    ->date(),

                TextColumn::make('item_rec_install_paid')
                    ->label('Successful recurring installments'),

                TextColumn::make('created_at')
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
                    ->columnSpan(2)
            ], layout: FiltersLayout::AboveContentCollapsible);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
