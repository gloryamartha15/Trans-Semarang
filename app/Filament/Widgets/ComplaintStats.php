<?php

namespace App\Filament\Widgets;

use App\Models\Complaints;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ComplaintStats extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $query = Complaints::query();

        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $total = (clone $query)->count();

        $diajukan = (clone $query)
            ->where('status_aduan', 'diajukan')
            ->count();

        $ditanggapi = (clone $query)
            ->where('status_aduan', 'ditanggapi')
            ->count();

        $selesai = (clone $query)
            ->where('status_aduan', 'selesai')
            ->count();

        return [
            Stat::make('Total Pengaduan', $total)
                ->description('Seluruh pengaduan dalam periode')
                ->color('primary'),

            Stat::make('Diajukan', $diajukan)
                ->description('Pengaduan baru masuk')
                ->color('warning'),

            Stat::make('Ditanggapi', $ditanggapi)
                ->description('Pengaduan telah diverifikasi')
                ->color('info'),

            Stat::make('Selesai', $selesai)
                ->description('Pengaduan telah diselesaikan')
                ->color('success'),
        ];
    }
}
