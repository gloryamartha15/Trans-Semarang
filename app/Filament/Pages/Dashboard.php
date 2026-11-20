<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;

class Dashboard extends BaseDashboard
{
    use HasFiltersAction;

    protected static ?string $title = 'Dashboard Pengaduan';

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->label('Filter Periode')
                ->icon('heroicon-o-calendar')
                ->schema([
                    Select::make('period')
                        ->label('Periode Pengaduan')
                        ->options([
                            'all' => 'Semua Masa',
                            'year_range' => 'Rentang Tahun',
                            'date_range' => 'Rentang Tanggal',
                        ])
                        ->default('all')
                        ->live()
                        ->required(),

                    Select::make('startYear')
                        ->label('Dari Tahun')
                        ->options(
                            collect(range(now()->year, 2020))
                                ->mapWithKeys(fn ($year) => [
                                    (string) $year => (string) $year,
                                ])
                                ->all()
                        )
                        ->default((string) now()->year)
                        ->live()
                        ->visible(fn (Get $get): bool => $get('period') === 'year_range')
                        ->required(fn (Get $get): bool => $get('period') === 'year_range'),

                    Select::make('endYear')
                        ->label('Sampai Tahun')
                        ->options(function (Get $get): array {
                            $startYear = (int) ($get('startYear') ?? now()->year);

                            return collect(range(now()->year, $startYear))
                                ->mapWithKeys(fn ($year) => [
                                    (string) $year => (string) $year,
                                ])
                                ->all();
                        })
                        ->default((string) now()->year)
                        ->live()
                        ->visible(fn (Get $get): bool => $get('period') === 'year_range')
                        ->required(fn (Get $get): bool => $get('period') === 'year_range')
                        ->rules([
                            fn (Get $get) => function (string $attribute, $value, $fail) use ($get) {
                                if (
                                    $value !== null &&
                                    $get('startYear') !== null &&
                                    (int) $value < (int) $get('startYear')
                                ) {
                                    $fail('Sampai tahun tidak boleh lebih kecil dari tahun awal.');
                                }
                            },
                        ]),

                    DatePicker::make('startDate')
                        ->label('Dari Tanggal')
                        ->native(false)
                        ->maxDate(now())
                        ->live()
                        ->visible(fn (Get $get): bool => $get('period') === 'date_range')
                        ->required(fn (Get $get): bool => $get('period') === 'date_range'),

                    DatePicker::make('endDate')
                        ->label('Sampai Tanggal')
                        ->native(false)
                        ->minDate(fn (Get $get) => $get('startDate'))
                        ->maxDate(now())
                        ->afterOrEqual('startDate')
                        ->visible(fn (Get $get): bool => $get('period') === 'date_range')
                        ->required(fn (Get $get): bool => $get('period') === 'date_range'),
                ]),
        ];
    }
}
