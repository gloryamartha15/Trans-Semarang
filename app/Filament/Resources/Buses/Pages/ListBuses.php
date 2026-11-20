<?php

namespace App\Filament\Resources\Buses\Pages;

use App\Filament\Resources\Buses\BusesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBuses extends ListRecords
{
    protected static string $resource = BusesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Bus'),
        ];
    }
}
