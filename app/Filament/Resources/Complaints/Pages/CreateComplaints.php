<?php

namespace App\Filament\Resources\Complaints\Pages;

use App\Filament\Resources\Complaints\ComplaintsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComplaints extends CreateRecord //ini untuk buat data baru (inheritance-konsep oop yaa)
{
    protected static string $resource = ComplaintsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['no_aduan']); //menghapus nilai nomor aduan dari array yang sedang diproses sebelum membuat nomor baru

        $tanggal = now()->format('Ymd');
        $prefix = 'ADU-' . $tanggal . '-';

        $nomorTerakhir = \App\Models\Complaints::where(
            'no_aduan',
            'like',
            $prefix . '%'
        )->orderBy('no_aduan', 'desc')->value('no_aduan');

        $urutan = $nomorTerakhir
            ? ((int) substr($nomorTerakhir, -4)) + 1
            : 1;

        $data['no_aduan'] = $prefix . str_pad($urutan, 4, '0', STR_PAD_LEFT);

        return $data;
    }
}