<?php

namespace App\Console\Commands;

use App\Models\Stops;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaraZeus\QrCode\Facades\QrCode;

class GenerateStopQrs extends Command
{
    protected $signature = 'stops:generate-qr';

    protected $description = 'Generate QR Code PNG untuk seluruh halte';

    public function handle(): int
    {
        $disk = Storage::disk('public');

        // Lokasi logo pada storage public
        $logoPath = 'qr/trans-semarang-logo.png';

        if (! $disk->exists($logoPath)) {
            $this->error('Logo tidak ditemukan: ' . $logoPath);

            return self::FAILURE;
        }

        $disk->makeDirectory('qr');

        $logo = $disk->get($logoPath);

        $stops = Stops::orderBy('id')->get();

        if ($stops->isEmpty()) {
            $this->warn('Belum ada data halte.');

            return self::SUCCESS;
        }

        foreach ($stops as $stop) {
            $url = rtrim(config('app.url'), '/')
                . '/aduan/create?stop_id=' . $stop->id;

            $fileName = 'QR_Halte_'
                . $stop->stops_number
                . '_'
                . Str::slug($stop->name_stop ?: 'tanpa-nama')
                . '.png';

            $filePath = 'qr/' . $fileName;

            // Generate QR Code PNG dengan logo
            QrCode::format('png')
                ->size(300)
                ->margin(1)
                ->errorCorrection('H')
                ->mergeString($logo, 0.2)
                ->generate(
                    $url,
                    $disk->path($filePath)
                );

            // Simpan URL dan konfigurasi QR ke database
            $stop->update([
                'qr_code' => $url,
                'qr_options' => [
                    'type' => 'png',
                    'correction' => 'H',
                    'percentage' => '.2',
                    'logo' => [$logoPath],
                    'uploadOptions' => [
                        'disk' => 'public',
                        'directory' => 'qr',
                    ],
                ],
            ]);

            $this->info(
                'Berhasil: ' . $stop->stops_number . ' - ' . $fileName
            );
        }

        $this->newLine();
        $this->info('Seluruh QR Code halte berhasil dibuat.');

        return self::SUCCESS;
    }
}
