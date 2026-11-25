<?php

namespace App\Console\Commands;

use App\Models\Buses;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaraZeus\QrCode\Facades\QrCode;

class GenerateBusQrs extends Command
{
    protected $signature = 'buses:generate-qr';

    protected $description = 'Generate QR Code PNG untuk seluruh bus';

    public function handle(): int
    {
        $disk = Storage::disk('public');

        $logoPath = 'qr/trans-semarang-logo.png';

        if (! $disk->exists($logoPath)) {
            $this->error('Logo tidak ditemukan: ' . $logoPath);

            return self::FAILURE;
        }

        $disk->makeDirectory('qr');

        $logo = $disk->get($logoPath);

        $buses = Buses::orderBy('id')->get();

        if ($buses->isEmpty()) {
            $this->warn('Belum ada data bus.');

            return self::SUCCESS;
        }

        foreach ($buses as $bus) {
            $url = rtrim(config('app.url'), '/')
                . '/aduan/create?bus_id=' . $bus->id;

            $fileName = 'QR_Bus_'
                . $bus->bus_number
                . '_'
                . Str::slug($bus->police_number)
                . '.png';

            $filePath = 'qr/' . $fileName;

            QrCode::format('png')
                ->size(300)
                ->margin(1)
                ->errorCorrection('H')
                ->mergeString($logo, 0.2)
                ->generate(
                    $url,
                    $disk->path($filePath)
                );

            $bus->update([
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

            $this->info('Berhasil: ' . $bus->bus_number);
        }

        $this->newLine();
        $this->info('Seluruh QR Code bus berhasil dibuat.');

        return self::SUCCESS;
    }
}
