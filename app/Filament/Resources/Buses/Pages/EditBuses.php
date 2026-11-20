<?php

namespace App\Filament\Resources\Buses\Pages;

use App\Filament\Resources\Buses\BusesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBuses extends EditRecord
{
    protected static string $resource = BusesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
