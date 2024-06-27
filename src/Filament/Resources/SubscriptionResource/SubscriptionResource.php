<?php

namespace Dasundev\PayHere\Filament\Resources\SubscriptionResource;

use Dasundev\PayHere\Models\Subscription;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Split;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
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
                TextColumn::make('id')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->searchable(),

                TextColumn::make('status')
                    ->searchable()
                    ->badge(),

                TextColumn::make('trial_ends_at')
                    ->searchable()
                    ->date(),

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
            ], layout: FiltersLayout::AboveContentCollapsible);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
        ];
    }
}
