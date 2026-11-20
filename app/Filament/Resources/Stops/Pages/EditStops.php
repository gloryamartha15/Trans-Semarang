<?php

namespace App\Filament\Resources\Stops\Pages;

use App\Filament\Resources\Stops\StopsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStops extends EditRecord
{
    protected static string $resource = StopsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
