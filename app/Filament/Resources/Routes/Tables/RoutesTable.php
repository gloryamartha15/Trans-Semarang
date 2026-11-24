<?php

namespace App\Filament\Resources\Routes\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class RoutesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('route_code')
                    ->label('Kode Rute')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('route_name')
                    ->label('Nama Rute')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_point')
                    ->label('Keberangkatan')
                    ->searchable(),

                TextColumn::make('end_point')
                    ->label('Tujuan')
                    ->searchable(),

                TextColumn::make('buses_count')
                    ->label('Jumlah Bus')
                    ->counts('buses')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

            ])
            ->filters([

                TernaryFilter::make('is_active')
                    ->label('Status Rute')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->placeholder('Semua Rute'),

            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
