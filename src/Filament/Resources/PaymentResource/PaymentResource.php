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
                TextColumn::make('payment_id')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->searchable(),

                TextColumn::make('payhere_amount')
                    ->searchable()
                    ->money(),

                TextColumn::make('captured_amount')
                    ->searchable()
                    ->money(),

                TextColumn::make('payhere_currency')
                    ->searchable()
                    ->badge(),

                TextColumn::make('status_message')
                    ->searchable()
                    ->label('Payment gateway message'),

                TextColumn::make('method')
                    ->searchable()
                    ->label('Payment method'),

                TextColumn::make('card_holder_name')
                    ->searchable(),

                TextColumn::make('card_no')
                    ->searchable(),

                TextColumn::make('card_expiry')
                    ->searchable(),

                IconColumn::make('recurring')
                    ->label('Recurring payment')
                    ->boolean()
                    ->searchable(),

                TextColumn::make('message_type')
                    ->label('Status message')
                    ->searchable(),

                TextColumn::make('status_code')
                    ->searchable(),

                TextColumn::make('subscription_id')
                    ->searchable(),

                TextColumn::make('item_recurrence')
                    ->label('How often it charges')
                    ->formatStateUsing(fn ($record) => Str::ucwords(strtolower($record->item_recurrence)))
                    ->searchable(),

                TextColumn::make('item_duration')
                    ->label('How long it charges')
                    ->formatStateUsing(fn ($record) => Str::ucwords(strtolower($record->item_duration)))
                    ->searchable(),

                TextColumn::make('item_rec_status')
                    ->label('Recurring subscription status')
                    ->searchable(),

                TextColumn::make('item_rec_date_next')
                    ->label('Next recurring installment')
                    ->date()
                    ->searchable(),

                TextColumn::make('item_rec_install_paid')
                    ->label('Successful recurring installments')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->date()
                    ->searchable(),
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
            ], layout: FiltersLayout::AboveContentCollapsible);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
