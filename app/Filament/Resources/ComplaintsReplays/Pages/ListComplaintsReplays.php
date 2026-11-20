<?php

namespace App\Filament\Resources\ComplaintsReplays\Pages;

use App\Filament\Resources\ComplaintsReplays\ComplaintsReplayResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListComplaintsReplays extends ListRecords
{
    protected static string $resource = ComplaintsReplayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Tanggapan'),
        ];
    }
}
