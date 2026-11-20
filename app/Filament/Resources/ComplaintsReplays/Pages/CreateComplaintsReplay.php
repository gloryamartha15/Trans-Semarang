<?php

namespace App\Filament\Resources\ComplaintsReplays\Pages;

use App\Filament\Resources\ComplaintsReplays\ComplaintsReplayResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateComplaintsReplay extends CreateRecord
{
    protected static string $resource = ComplaintsReplayResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_petugas'] = Auth::id();

        return $data;
    }
}
