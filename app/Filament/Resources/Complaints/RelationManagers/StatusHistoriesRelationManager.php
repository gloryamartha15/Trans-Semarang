<?php

namespace App\Filament\Resources\Complaints\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class StatusHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'statusHistories';

    protected static ?string $title = 'Riwayat Status Aduan';

    /**
     * Riwayat bersifat read-only.
     * Tidak dapat diedit atau dihapus melalui panel.
     */
    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([

                // Status sebelumnya
                TextColumn::make('old_status')
                    ->label('Status Sebelumnya')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'ditanggapi' => 'info',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'diajukan' => 'Diajukan',
                            'ditanggapi' => 'Ditanggapi',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak',
                            default => 'Status Awal',
                        }
                    ),

                // Status baru
                TextColumn::make('new_status')
                    ->label('Status Baru')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'diajukan' => 'warning',
                        'ditanggapi' => 'info',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'diajukan' => 'Diajukan',
                            'ditanggapi' => 'Ditanggapi',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak',
                            default => '-',
                        }
                    ),

                // Tanggapan awal petugas
                TextColumn::make('tanggapan_petugas')
                    ->label('Tanggapan Petugas')
                    ->state(function ($record) {
                        if ($record->new_status !== 'ditanggapi') {
                            return null;
                        }

                        return $record->complaint?->replays()
                            ->where('created_at', '<=', $record->created_at)
                            ->latest('created_at')
                            ->latest('id')
                            ->value('tanggapan');
                    })
                    ->wrap()
                    ->placeholder('-'),

                // Catatan perubahan status
                TextColumn::make('notes')
                    ->label('Catatan / Hasil Tindak Lanjut')
                    ->wrap()
                    ->placeholder('-'),

                // Identitas pelaku
                TextColumn::make('user.name')
                    ->label('Pelaku Perubahan')
                    ->placeholder('Tidak diketahui')
                    ->searchable(),

                // Waktu perubahan
                TextColumn::make('created_at')
                    ->label('Tanggal dan Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

            ])

            ->defaultSort('created_at', 'desc')

            // Tidak menyediakan aksi edit dan hapus.
            ->recordActions([]);
    }
}
