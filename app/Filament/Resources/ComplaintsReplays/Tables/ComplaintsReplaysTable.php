<?php

namespace App\Filament\Resources\ComplaintsReplays\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ComplaintsReplaysTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('complaints.no_aduan')
                    ->label('Nomor Pengaduan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('petugas.name')
                    ->label('Petugas')
                    ->placeholder('-'),

                TextColumn::make('tanggapan')
                    ->label('Tanggapan')
                    ->limit(60)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Tanggal Tanggapan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->label('Edit Tanggapan'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
