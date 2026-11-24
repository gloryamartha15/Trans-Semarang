<?php

namespace App\Filament\Resources\Petugas\Pages;

use App\Filament\Resources\Petugas\PetugasResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePetugas extends CreateRecord
{
    protected static string $resource = PetugasResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Memastikan role database selalu petugas.
        $data['role'] = 'petugas';

        return $data;
    }

    protected function afterCreate(): void
    {
        // Menyinkronkan Spatie Role setelah akun dibuat.
        $this->record->syncRoles(['petugas']);
    }
}
