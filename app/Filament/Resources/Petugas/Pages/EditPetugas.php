<?php

namespace App\Filament\Resources\Petugas\Pages;

use App\Filament\Resources\Petugas\PetugasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPetugas extends EditRecord
{
    protected static string $resource = PetugasResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Memastikan role tetap petugas.
        $data['role'] = 'petugas';

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Petugas'),
        ];
    }
}
