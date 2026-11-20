<?php

namespace App\Filament\Resources\Stops\Pages;

use App\Filament\Resources\Stops\StopsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStops extends ListRecords
{
    protected static string $resource = StopsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Halte'),
        ];
    }
}
