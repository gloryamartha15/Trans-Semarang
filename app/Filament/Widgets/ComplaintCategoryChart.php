<?php

namespace App\Filament\Widgets;

use App\Models\Categories;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Query\JoinClause;

class ComplaintCategoryChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Jumlah Pengaduan Berdasarkan Kategori';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = '1/2';

    protected function getData(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        $categories = Categories::query()
            ->leftJoin('complaints', function (JoinClause $join) use ($startDate, $endDate) {
                $join->on('categories.id', '=', 'complaints.categories_id');

                if ($startDate) {
                    $join->whereDate('complaints.created_at', '>=', $startDate);
                }

                if ($endDate) {
                    $join->whereDate('complaints.created_at', '<=', $endDate);
                }
            })
            ->select('categories.jenis_aduan')
            ->selectRaw('COUNT(complaints.id) as total')
            ->groupBy('categories.id', 'categories.jenis_aduan')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pengaduan',
                    'data' => $categories->pluck('total')->toArray(),
                ],
            ],
            'labels' => $categories->pluck('jenis_aduan')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
