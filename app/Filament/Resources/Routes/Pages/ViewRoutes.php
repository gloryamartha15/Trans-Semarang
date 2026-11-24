<?php

namespace App\Filament\Resources\Routes\Pages;

use App\Filament\Resources\Routes\RoutesResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class ViewRoutes extends ViewRecord
{
    protected static string $resource = RoutesResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Rute')
                    ->description('Detail informasi jalur perjalanan Trans Semarang.')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextEntry::make('route_code')
                                    ->label('Kode Rute'),

                                TextEntry::make('route_name')
                                    ->label('Nama Rute'),

                                TextEntry::make('start_point')
                                    ->label('Titik Keberangkatan'),

                                TextEntry::make('end_point')
                                    ->label('Titik Tujuan'),

                                IconEntry::make('is_active')
                                    ->label('Status Rute')
                                    ->boolean(),

                            ]),

                    ]),

                Section::make('Halte yang Dilewati')
                    ->description('Daftar halte berdasarkan urutan perjalanan.')
                    ->schema([

                        RepeatableEntry::make('routeStops')
                            ->label('')
                            ->schema([

                                TextEntry::make('stop_order')
                                    ->label('Urutan'),

                                TextEntry::make('stop.stops_number')
                                    ->label('Nomor Halte'),

                                TextEntry::make('stop.name_stop')
                                    ->label('Nama Halte'),

                            ])
                            ->columns(3),

                    ]),

            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
