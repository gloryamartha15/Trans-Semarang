<?php

namespace App\Filament\Widgets;

use App\Models\Complaints;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ComplaintMonthlyChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Tren Pengaduan';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = '1/2';

    protected function getData(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        $mulai = $startDate
            ? Carbon::parse($startDate)->startOfDay()
            : Carbon::now()->startOfYear();

        $sampai = $endDate
            ? Carbon::parse($endDate)->endOfDay()
            : Carbon::now()->endOfDay();

        if ($mulai->gt($sampai)) {
            return [
                'datasets' => [
                    ['label' => 'Jumlah Pengaduan', 'data' => []],
                ],
                'labels' => [],
            ];
        }

        $harian = $mulai->diffInDays($sampai) <= 30;

        if ($harian) {
            $data = Complaints::query()
                ->selectRaw('DATE(created_at) as periode')
                ->selectRaw('COUNT(*) as total')
                ->whereBetween('created_at', [$mulai, $sampai])
                ->groupBy('periode')
                ->pluck('total', 'periode');

            $labels = [];
            $jumlah = [];

            $tanggal = $mulai->copy()->startOfDay();

            while ($tanggal->lte($sampai)) {
                $key = $tanggal->toDateString();

                $labels[] = $tanggal->format('d M');
                $jumlah[] = (int) ($data[$key] ?? 0);

                $tanggal->addDay();
            }
        } else {
            $data = Complaints::query()
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as periode")
                ->selectRaw('COUNT(*) as total')
                ->whereBetween('created_at', [$mulai, $sampai])
                ->groupBy('periode')
                ->pluck('total', 'periode');

            $labels = [];
            $jumlah = [];

            $bulan = $mulai->copy()->startOfMonth();
            $akhir = $sampai->copy()->startOfMonth();

            while ($bulan->lte($akhir)) {
                $key = $bulan->format('Y-m');

                $labels[] = $bulan->translatedFormat('M Y');
                $jumlah[] = (int) ($data[$key] ?? 0);

                $bulan->addMonth();
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengaduan',
                    'data' => $jumlah,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.15)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
