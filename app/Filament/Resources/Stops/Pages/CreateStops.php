<?php

namespace App\Filament\Resources\Stops\Pages;

use App\Filament\Resources\Stops\StopsResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateStops extends CreateRecord
{
    protected static string $resource = StopsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Simpan konfigurasi QR Code dan logo otomatis
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

        // UUID sementara untuk memenuhi aturan unique
        $data['qr_code'] = (string) Str::uuid();

        return $data;
    }

    protected function afterCreate(): void
    {
        // Ambil ID halte yang sudah tersimpan
        $stopId = $this->record->getKey();

        // Bentuk URL otomatis berdasarkan APP_URL
        $url = rtrim(config('app.url'), '/')
            . '/aduan/create?stop_id=' . $stopId;

        // Simpan URL sebenarnya
        $this->record->update([
            'qr_code' => $url,
        ]);
    }
}
