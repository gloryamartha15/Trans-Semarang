<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Memastikan role database tetap pengguna.
        $data['role'] = 'pengguna';

        return $data;
    }

    protected function afterSave(): void
    {
        // Menyinkronkan Spatie Role.
        $this->record->syncRoles(['pengguna']);
    }
}
