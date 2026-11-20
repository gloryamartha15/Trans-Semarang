<?php

namespace App\Filament\Resources\ComplaintsReplays\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ComplaintsReplayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('complaints_id')
                    ->label('Nomor Pengaduan')
                    ->relationship('complaints', 'no_aduan')
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('tanggapan')
                    ->label('Tanggapan Petugas')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
