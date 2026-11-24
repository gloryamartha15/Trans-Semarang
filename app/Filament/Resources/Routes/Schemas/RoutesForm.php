<?php

namespace App\Filament\Resources\Routes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoutesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Rute')
                    ->description('Masukkan informasi jalur perjalanan Trans Semarang.')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('route_code')
                                    ->label('Kode Rute')
                                    ->placeholder('Contoh: NGY-BSB')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                TextInput::make('route_name')
                                    ->label('Nama Rute')
                                    ->placeholder('Contoh: Ngaliyan - BSB')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('start_point')
                                    ->label('Titik Keberangkatan')
                                    ->placeholder('Contoh: Ngaliyan')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('end_point')
                                    ->label('Titik Tujuan')
                                    ->placeholder('Contoh: BSB')
                                    ->required()
                                    ->maxLength(255),

                            ]),

                    ]),

                Section::make('Status Rute')
                    ->schema([

                        Toggle::make('is_active')
                            ->label('Rute Aktif')
                            ->helperText('Aktifkan jika rute masih beroperasi.')
                            ->default(true)
                            ->required(),

                    ]),

            ]);
    }
}
