<?php

namespace App\Filament\Resources\ComplaintsReplays\Pages;

use App\Filament\Resources\ComplaintsReplays\ComplaintsReplayResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditComplaintsReplay extends EditRecord
{
    protected static string $resource = ComplaintsReplayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
