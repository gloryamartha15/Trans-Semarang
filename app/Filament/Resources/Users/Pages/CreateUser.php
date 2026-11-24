<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Memastikan role database selalu pengguna.
        $data['role'] = 'pengguna';

        return $data;
    }

    protected function afterCreate(): void
    {
        // Menyinkronkan Spatie Role setelah akun dibuat.
        $this->record->syncRoles(['pengguna']);
    }
}
