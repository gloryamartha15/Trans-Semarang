<?php

namespace App\Filament\Resources\Complaints\RelationManagers;

use App\Filament\Resources\Complaints\ComplaintsResource;
use App\Models\Complaints;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReplaysRelationManager extends RelationManager
{
    protected static string $relationship = 'replays';

    protected static ?string $recordTitleAttribute = 'tanggapan';

    public function isReadOnly(): bool
    {
        return false;
    }

    /**
     * Memeriksa hak akses memberikan tanggapan.
     */
    private function canCreateReplay(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof User
            && in_array($user->role, [
                'super_admin',
                'admin',
                'petugas',
            ], true);
    }

    /**
     * Memeriksa apakah pengguna boleh menambahkan tanggapan.
     *
     * Super Admin bebas memberikan tanggapan.
     * Admin dan Petugas hanya boleh memberikan
     * satu tanggapan pada setiap siklus.
     */
    private function canReply(): bool
    {
        $user = Filament::auth()->user();

        if (! $user instanceof User) {
            return false;
        }

        // Super Admin tidak dibatasi status maupun jumlah tanggapan.
        if ($user->role === 'super_admin') {
            return true;
        }

        if (! in_array($user->role, ['admin', 'petugas'], true)) {
            return false;
        }

        $complaint = $this->getOwnerRecord();

        if ($complaint->status_aduan !== 'diajukan') {
            return false;
        }

        return ! $complaint->replays()
            ->where('cycle_number', $complaint->response_cycle)
            ->exists();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('tanggapan')
                ->label('Tanggapan')
                ->placeholder(
                    'Tuliskan tanggapan terhadap pengaduan...'
                )
                ->required()
                ->minLength(10)
                ->maxLength(5000)
                ->rows(5)
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggapan')
                    ->label('Tanggapan')
                    ->wrap(),

                TextColumn::make('petugas.name')
                    ->label('Petugas')
                    ->placeholder('-'),

                TextColumn::make('cycle_number')
                    ->label('Siklus'),

                TextColumn::make('created_at')
                    ->label('Tanggal Tanggapan')
                    ->dateTime('d M Y H:i'),
            ])

            ->headerActions([

                CreateAction::make()
                    ->label('Tambah Tanggapan')
                    ->modalHeading('Buat Tanggapan Aduan')
                    ->modalWidth('2xl')
                    ->modalSubmitActionLabel('Simpan Tanggapan')
                    ->modalCancelActionLabel('Batal')

                    ->visible(fn (): bool =>
                        $this->canReply()
                    )

                    ->using(function (array $data): Model {

                        $user = Filament::auth()->user();

                        abort_unless(
                            $user instanceof User
                                && in_array($user->role, [
                                    'super_admin',
                                    'admin',
                                    'petugas',
                                ], true),
                            403
                        );

                        return DB::transaction(
                            function () use ($data, $user): Model {

                                // Kunci data aduan agar tidak terjadi
                                // tanggapan ganda secara bersamaan.
                                $complaint = Complaints::query()
                                    ->lockForUpdate()
                                    ->findOrFail(
                                        $this->getOwnerRecord()->getKey()
                                    );

                                $cycle = $complaint->response_cycle;

                                $isSuperAdmin =
                                    $user->role === 'super_admin';

                                // Admin dan Petugas hanya boleh
                                // menanggapi aduan yang diajukan.
                                if (! $isSuperAdmin) {

                                    if (
                                        $complaint->status_aduan !== 'diajukan'
                                    ) {
                                        throw ValidationException::withMessages([
                                            'tanggapan' =>
                                                'Aduan sudah ditanggapi atau tidak dapat ditanggapi saat ini.',
                                        ]);
                                    }

                                    // Cegah tanggapan kedua dalam
                                    // siklus yang sama.
                                    $alreadyReplied = $complaint->replays()
                                        ->where('cycle_number', $cycle)
                                        ->exists();

                                    if ($alreadyReplied) {
                                        throw ValidationException::withMessages([
                                            'tanggapan' =>
                                                'Aduan sudah memiliki tanggapan pada siklus ini.',
                                        ]);
                                    }
                                }

                                // Simpan tanggapan.
                                $record = $complaint->replays()->create([
                                    'tanggapan' => $data['tanggapan'],
                                    'id_petugas' => $user->id,
                                    'cycle_number' => $cycle,
                                ]);

                                /*
                                 * Hanya perubahan dari Diajukan
                                 * menjadi Ditanggapi yang mengubah
                                 * status dan membuat riwayat.
                                 *
                                 * Tanggapan tambahan Super Admin
                                 * tidak mengubah status aduan.
                                 */
                                if (
                                    $complaint->status_aduan === 'diajukan'
                                ) {
                                    $complaint->update([
                                        'status_aduan' => 'ditanggapi',
                                    ]);

                                    $complaint->statusHistories()->create([
                                        'user_id' => $user->id,
                                        'old_status' => 'diajukan',
                                        'new_status' => 'ditanggapi',
                                        'notes' =>
                                            'Tanggapan awal: ' .
                                            $data['tanggapan'],
                                    ]);
                                }

                                return $record;
                            }
                        );
                    })

                    ->after(function ($record, $livewire): void {

                        $complaint = $livewire->getOwnerRecord();

                        // Kembali ke halaman detail aduan.
                        $livewire->redirect(
                            ComplaintsResource::getUrl(
                                'view',
                                [
                                    'record' => $complaint->getKey(),
                                ]
                            ),
                            navigate: true
                        );
                    }),
            ])

            ->recordActions([]);
    }
}