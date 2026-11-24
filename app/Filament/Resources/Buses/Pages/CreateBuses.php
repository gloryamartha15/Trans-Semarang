<?php

namespace App\Filament\Resources\Buses\Pages;

use App\Filament\Resources\Buses\BusesResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateBuses extends CreateRecord
{
    protected static string $resource = BusesResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['qr_options'] = [
            'type' => 'png',
            'correction' => 'H',
            'percentage' => '.2',
            'logo' => [
                'qr/trans-semarang-logo.png',
            ],
            'uploadOptions' => [
                'disk' => 'public',
                'directory' => 'qr',
            ],
        ];

        $data['qr_code'] = (string) Str::uuid();

        return $data;
    }

    protected function afterCreate(): void
    {
        $busId = $this->record->getKey();

        $url = rtrim(config('app.url'), '/')
            . '/aduan/create?bus_id=' . $busId;

        $this->record->update([
            'qr_code' => $url,
        ]);
    }
}
