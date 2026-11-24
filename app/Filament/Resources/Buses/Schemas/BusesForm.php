<?php

namespace App\Filament\Resources\Buses\Schemas;

use App\Models\Buses;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use LaraZeus\Qr\Facades\Qr as QrFacade;

class BusesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Grid::make([
                'default' => 1,
                'md' => 2,
            ])
                ->schema([

                    // INFORMASI BUS
                    Section::make('Informasi Bus')
                        ->schema([

                            TextInput::make('police_number')
                                ->label('Nomor Polisi')
                                ->required(),

                            TextInput::make('bus_number')
                                ->label('Nomor Bus')
                                ->default(null),

                            Select::make('route_id')
                                ->label('Rute Bus')
                                ->relationship(
                                    name: 'route',
                                    titleAttribute: 'route_name'
                                )
                                ->searchable()
                                ->preload()
                                ->nullable(),

                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->required(),

                            Placeholder::make('qr_code_info')
                                ->label('Alamat QR Code')
                                ->content('Alamat QR Code dibuat otomatis oleh sistem setelah data bus disimpan.')
                                ->visibleOn('create'),

                            Placeholder::make('qr_address')
                                ->label('Alamat QR Code')
                                ->content(fn (?Buses $record) =>
                                    $record?->qr_code ?? 'QR Code belum tersedia.'
                                )
                                ->visibleOn('edit'),

                        ])
                        ->columns(1),

                    // INFORMASI QR SAAT TAMBAH BUS
                    Placeholder::make('qr_info')
                        ->label('QR Code')
                        ->content('QR Code beserta logo Trans Semarang akan dibuat otomatis setelah data bus disimpan.')
                        ->visibleOn('create'),

                    // PREVIEW QR SAAT EDIT BUS
                    Placeholder::make('qr_preview')
                        ->label('Preview QR Code')
                        ->content(function (?Buses $record) {

                            if (! $record?->qr_code) {
                                return 'QR Code belum tersedia.';
                            }

                            return QrFacade::render(
                                data: $record->qr_code,
                                options: $record->qr_options,
                                fileName: 'QR_Bus_' .
                                    Str::upper(
                                        Str::slug(
                                            $record->police_number ?: 'tanpa-nomor'
                                        )
                                    )
                            );
                        })
                        ->visibleOn('edit'),

                ])
                ->columnSpanFull(),

        ]);
    }
}
