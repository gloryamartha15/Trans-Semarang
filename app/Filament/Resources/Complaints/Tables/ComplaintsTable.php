<?php

namespace App\Filament\Resources\Complaints\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

                TextColumn::make('buses.police_number')
                    ->label('Nomor Polisi Bus')
                    ->placeholder('-'),

                TextColumn::make('stops.name_stop')
                    ->label('Nama Halte')
                    ->placeholder('-'),

                TextColumn::make('status_aduan')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'ditanggapi' => 'info',
                        'selesai' => 'success',
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
                    ]),

                SelectFilter::make('categories_id')
                    ->label('Filter Kategori')
                    ->relationship('categories', 'jenis_aduan'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Kelola'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
