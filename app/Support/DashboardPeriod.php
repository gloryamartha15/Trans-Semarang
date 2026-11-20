<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class DashboardPeriod
{
    public static function getRange(array $filters): array
    {
        $period = $filters['period'] ?? 'all';

        if ($period === 'year_range') {
            $startYear = (int) ($filters['startYear'] ?? now()->year);
            $endYear = (int) ($filters['endYear'] ?? now()->year);

            if ($startYear > $endYear) {
                return [null, null];
            }

            return [
                Carbon::create($startYear, 1, 1)->startOfDay(),
                Carbon::create($endYear, 12, 31)->endOfDay(),
            ];
        }

        if ($period === 'date_range') {
            $start = $filters['startDate'] ?? null;
            $end = $filters['endDate'] ?? null;

            if (!$start || !$end) {
                return [null, null];
            }

            $startDate = Carbon::parse($start)->startOfDay();
            $endDate = Carbon::parse($end)->endOfDay();

            if ($startDate->gt($endDate)) {
                return [null, null];
            }

            return [$startDate, $endDate];
        }

        // Semua Masa: tidak membatasi tanggal.
        return [null, null];
    }

    public static function apply(
        Builder $query,
        array $filters
    ): Builder {
        [$start, $end] = self::getRange($filters);

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        return $query;
    }
}
