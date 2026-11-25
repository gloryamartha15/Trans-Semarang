<?php

namespace App\Filament\Resources\Stops\Schemas;

use App\Models\Stops;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use LaraZeus\Qr\Facades\Qr as QrFacade;
use Illuminate\Support\Str;

class StopsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Grid::make([
                'default' => 1,
                'md' => 2,
            ])
                ->schema([

                    // KOLOM KIRI: INFORMASI HALTE
                    Section::make('Informasi Halte')
                        ->schema([
                            TextInput::make('stops_number')
                                ->label('Nomor Halte')
                                ->required(),

                            TextInput::make('name_stop')
                                ->label('Nama Halte')
                                ->default(null),

                            Textarea::make('address')
                                ->label('Alamat Halte')
                                ->placeholder('Masukkan alamat atau lokasi halte')
                                ->rows(3)
                                ->maxLength(500)
                                ->nullable()
                                ->columnSpanFull(),

                            Placeholder::make('qr_code_info')
                                ->label('Alamat QR Code')
                                ->content('Alamat QR Code dibuat otomatis oleh sistem setelah data halte disimpan.')
                                ->visibleOn('create'),
                        ])
                        ->columns(1),

                    // INFORMASI QR CODE SAAT CREATE
                    Placeholder::make('qr_info')
                        ->label('QR Code')
                        ->content('QR Code beserta logo Trans Semarang akan dibuat otomatis setelah data halte disimpan.')
                        ->visibleOn('create'),

                    // PREVIEW QR CODE SAAT EDIT
                    Placeholder::make('qr_preview')
                        ->label('Preview QR Code')
                        ->content(function (?Stops $record) {
                            if (! $record?->qr_code) {
                                return 'QR Code belum tersedia.';
                            }

                            return QrFacade::render(
                                data: $record->qr_code,
                                options: $record->qr_options,
                                fileName: 'QR_Halte_' .
                                    $record->stops_number . '_' .
                                    Str::slug($record->name_stop ?: 'tanpa-nama')
                            );
                        })
                        ->visibleOn('edit'),

                ])
                ->columnSpanFull(),

        ]);
    }
}
