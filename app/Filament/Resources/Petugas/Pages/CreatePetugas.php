<?php

namespace App\Filament\Resources\Petugas\Pages;

use App\Filament\Resources\Petugas\PetugasResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePetugas extends CreateRecord
{
    protected static string $resource = PetugasResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Memastikan akun yang dibuat selalu memiliki role petugas.
        $data['role'] = 'petugas';

        return $data;
    }
}
