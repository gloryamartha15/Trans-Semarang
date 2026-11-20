<?php

namespace App\Filament\Widgets;

use App\Models\Complaints;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class ComplaintLatestTable extends TableWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 4;

    protected static ?string $heading = 'Pengaduan Terbaru';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                $query = Complaints::query()
                    ->with(['categories'])
                    ->latest();

                $startDate = $this->pageFilters['startDate'] ?? null;
                $endDate = $this->pageFilters['endDate'] ?? null;

                if ($startDate) {
                    $query->whereDate('created_at', '>=', $startDate);
                }

                if ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                }

                return $query;
            })
            ->columns([
                TextColumn::make('no_aduan')
                    ->label('Nomor Pengaduan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('judul')
                    ->label('Judul Pengaduan')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('categories.jenis_aduan')
                    ->label('Kategori')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('status_aduan')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'ditanggapi' => 'info',
                        'selesai' => 'success',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(5)
            ->paginated([5, 10, 25]);
    }
}
