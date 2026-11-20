<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ComplaintsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no_aduan')
                    ->label('Nomor Pengaduan')
                    ->disabled()
                    ->dehydrated()
                    ->placeholder('Dibuat otomatis oleh sistem'),

                TextInput::make('nama_pengadu')
                    ->label('Nama Pengadu')
                    ->required()
                    ->maxLength(255),

                Select::make('bus_id')
                    ->label('Bus')
                    ->relationship('buses', 'police_number')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Select::make('stop_id')
                    ->label('Halte')
                    ->relationship('stops', 'name_stop')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Select::make('categories_id')
                    ->label('Kategori Pengaduan')
                    ->relationship('categories', 'jenis_aduan')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('judul')
                    ->label('Judul Pengaduan')
                    ->required()
                    ->maxLength(255),

                Textarea::make('isi_aduan')
                    ->label('Isi Pengaduan')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                FileUpload::make('dokumentasi')
                    ->label('Bukti Foto')
                    ->image()
                    ->disk('public')
                    ->directory('dokumentasi')
                    ->visibility('public')
                    ->imageEditor()
                    ->nullable()
                    ->columnSpanFull(),

                Select::make('status_aduan')
                    ->label('Status Pengaduan')
                    ->options([
                        'diajukan' => 'Diajukan',
                        'ditindaklanjuti' => 'Ditanggapi',
                        'selesai' => 'Selesai',
                    ])
                    ->default('diajukan')
                    ->required(),
            ])
            ->columns(2);
    }
}
