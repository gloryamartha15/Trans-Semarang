<?php

namespace App\Filament\Resources\Complaints\Pages;

use App\Filament\Resources\Complaints\ComplaintsResource;
use App\Models\Complaints;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewComplaints extends ViewRecord
{
    protected static string $resource = ComplaintsResource::class;

    private function canChangeComplaintStatus(): bool
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return false;
        }

        if ($user->role === 'super_admin') {
            return true;
        }

        return in_array($user->role, ['admin', 'petugas'], true)
            && $user->hasPermissionTo('Update:ComplaintStatus', 'admin');
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('changeStatus')
                ->label('Ubah Status')
                ->color('warning')
                ->schema([
                    Select::make('new_status')
                        ->label('Status Baru')
                        ->options([
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak',
                        ])
                        ->required(),

                    Textarea::make('notes')
                        ->label('Catatan / Alasan')
                        ->placeholder('Jelaskan hasil tindak lanjut atau alasan penolakan...')
                        ->required()
                        ->minLength(10)
                        ->maxLength(2000)
                        ->rows(4),
                ])
                ->visible(function (): bool {
                    $user = Auth::user();

                    return $user instanceof User
                        && (
                            $user->role === 'super_admin'
                            || (
                                in_array($user->role, ['admin', 'petugas'], true)
                                && $user->hasPermissionTo('Update:ComplaintStatus', 'admin')
                            )
                        )
                        && in_array($this->getRecord()->status_aduan, [
                            'diajukan',
                            'ditanggapi',
                        ], true);
                })
                ->modalHeading('Ubah Status Aduan')
                ->modalSubmitActionLabel('Simpan Perubahan')
                ->action(function (array $data): void {
                    $user = Auth::user();

                    abort_unless(
                        $user instanceof User
                            && (
                                $user->role === 'super_admin'
                                || (
                                    in_array($user->role, ['admin', 'petugas'], true)
                                    && $user->hasPermissionTo('Update:ComplaintStatus', 'admin')
                                )
                            ),
                        403
                    );

                    abort_unless(
                        in_array($data['new_status'] ?? null, [
                            'selesai',
                            'ditolak',
                        ], true),
                        422
                    );

                    $notes = trim($data['notes'] ?? '');

                    abort_if($notes === '', 422);

                    DB::transaction(function () use ($data, $notes, $user): void {
                        $complaint = Complaints::query()
                            ->lockForUpdate()
                            ->findOrFail($this->getRecord()->getKey());

                        abort_unless(
                            in_array($complaint->status_aduan, [
                                'diajukan',
                                'ditanggapi',
                            ], true),
                            422
                        );

                        $oldStatus = $complaint->status_aduan;
                        $newStatus = $data['new_status'];

                        $complaint->update([
                            'status_aduan' => $newStatus,
                        ]);

                        $complaint->statusHistories()->create([
                            'user_id' => $user->id,
                            'old_status' => $oldStatus,
                            'new_status' => $newStatus,
                            'notes' => $notes,
                        ]);
                    });

                    $this->getRecord()->refresh();
                }),

            Action::make('reopen')
                ->label('Buka Kembali Aduan')
                ->color('success')
                ->icon('heroicon-o-arrow-path')
                ->schema([
                    Textarea::make('notes')
                        ->label('Alasan Membuka Kembali Aduan')
                        ->placeholder('Jelaskan alasan aduan perlu dibuka kembali...')
                        ->required()
                        ->minLength(10)
                        ->maxLength(2000)
                        ->rows(4),
                ])
                ->visible(function (): bool {
                    $user = Auth::user();

                    return $user instanceof User
                        && in_array($user->role, [
                            'super_admin',
                            'admin',
                        ], true)
                        && in_array($this->getRecord()->status_aduan, [
                            'selesai',
                            'ditolak',
                        ], true);
                })
                ->modalHeading('Buka Kembali Aduan')
                ->modalDescription('Aduan akan kembali ke status Diajukan dan memasuki siklus tanggapan baru.')
                ->modalSubmitActionLabel('Buka Kembali')
                ->action(function (array $data): void {
                    $user = Auth::user();

                    abort_unless(
                        $user instanceof User
                            && in_array($user->role, [
                                'super_admin',
                                'admin',
                            ], true),
                        403
                    );

                    $notes = trim($data['notes'] ?? '');

                    abort_if(
                        mb_strlen($notes) < 10,
                        422
                    );

                    DB::transaction(function () use ($notes, $user): void {
                        $complaint = Complaints::query()
                            ->lockForUpdate()
                            ->findOrFail($this->getRecord()->getKey());

                        abort_unless(
                            in_array($complaint->status_aduan, [
                                'selesai',
                                'ditolak',
                            ], true),
                            422
                        );

                        $oldStatus = $complaint->status_aduan;

                        $complaint->update([
                            'status_aduan' => 'diajukan',
                            'response_cycle' => $complaint->response_cycle + 1,
                        ]);

                        $complaint->statusHistories()->create([
                            'user_id' => $user->id,
                            'old_status' => $oldStatus,
                            'new_status' => 'diajukan',
                            'notes' => $notes,
                        ]);
                    });

                    $this->getRecord()->refresh();
                }),
        ];
    }
}
