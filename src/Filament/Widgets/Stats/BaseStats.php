<?php

namespace Dasundev\PayHere\Filament\Widgets\Stats;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

abstract class BaseStats
{
    abstract protected static function getQuery(): Builder;

    protected static function getCountForPeriod(Carbon $start, Carbon $end): int
    {
        return static::getQuery()->whereBetween('created_at', [$start, $end])->count();
    }

    protected static function calculateDifference(int $currentCount, int $previousCount): array
    {
        $difference = $currentCount - $previousCount;
        $increase = Number::abbreviate($difference);

        $isIncrease = $difference > 0;

        return [
            'description' => "{$increase} " . ($isIncrease ? 'increase' : 'decrease'),
            'icon' => $isIncrease ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down',
            'color' => $isIncrease ? 'success' : 'danger',
        ];
    }

    protected static function getTrendData(): array
    {
        $query = static::getQuery();

        $trend = Trend::query($query)
            ->between(
                start: now()->startOfWeek(),
                end: now()->endOfWeek(),
            )
            ->perDay()
            ->count();

        return $trend->map(fn (TrendValue $value) => $value->aggregate)->toArray();
    }

    public static function getStats(): array
    {
        $oneWeekAgo = now()->subDays(7);
        $twoWeeksAgo = now()->subDays(14);
        $currentTime = Carbon::now();

        $previousCount = static::getCountForPeriod($twoWeeksAgo, $oneWeekAgo);
        $currentCount = static::getCountForPeriod($oneWeekAgo, $currentTime);

        $differenceData = static::calculateDifference($currentCount, $previousCount);

        return [
            'count' => $currentCount,
            'description' => $differenceData['description'],
            'icon' => $differenceData['icon'],
            'color' => $differenceData['color'],
            'chartData' => static::getTrendData(),
        ];
    }
}
