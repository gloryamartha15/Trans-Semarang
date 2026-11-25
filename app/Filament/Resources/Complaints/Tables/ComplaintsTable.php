<?php

namespace App\Filament\Resources\Complaints\Tables;

use App\Filament\Resources\Complaints\ComplaintsResource;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ComplaintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_aduan')
                    ->label('Nomor Aduan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_pengadu')
                    ->label('Nama Pengadu')
                    ->searchable(),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('categories.jenis_aduan')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('bus.police_number')
                    ->label('Nomor Polisi Bus')
                    ->placeholder('-'),

                TextColumn::make('stop.name_stop')
                    ->label('Nama Halte')
                    ->placeholder('-'),

                TextColumn::make('status_aduan')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'ditanggapi' => 'info',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(
                        fn (string $state): string => ucfirst($state)
                    ),

                TextColumn::make('created_at')
                    ->label('Tanggal Pengaduan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status_aduan')
                    ->label('Filter Status')
                    ->options([
                        'diajukan' => 'Diajukan',
                        'ditanggapi' => 'Ditanggapi',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ]),

                SelectFilter::make('categories_id')
                    ->label('Filter Kategori')
                    ->relationship('categories', 'jenis_aduan'),
            ])
            ->recordActions([
                Action::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record): string =>
                        ComplaintsResource::getUrl('view', [
                            'record' => $record,
                        ])
                    )
                    ->visible(true),
            ]);
    }
}
