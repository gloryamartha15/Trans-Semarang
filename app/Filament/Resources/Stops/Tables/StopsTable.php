<?php

namespace App\Filament\Resources\Stops\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StopsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('stops_number')
                    ->label('Nomor Halte')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name_stop')
                    ->label('Nama Halte')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('address')
                    ->label('Alamat Halte')
                    ->searchable()
                    ->limit(45)
                    ->tooltip(fn ($record) => $record->address),

                TextColumn::make('qr_code')
                    ->label('QR Code')
                    ->searchable()
                    ->placeholder('Belum tersedia'),

                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Nonaktif')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
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
