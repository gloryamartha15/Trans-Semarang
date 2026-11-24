<?php

namespace App\Filament\Resources\Complaints\RelationManagers;

use App\Filament\Resources\Complaints\ComplaintsResource;
use App\Models\Complaints;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReplaysRelationManager extends RelationManager
{
    public function isReadOnly(): bool
    {
        return false;
    }

    protected static string $relationship = 'replays';

    protected static ?string $recordTitleAttribute = 'tanggapan';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('tanggapan')
                ->label('Tanggapan')
                ->placeholder('Tuliskan tanggapan terhadap pengaduan...')
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
                        in_array(
                            Auth::user()?->role,
                            ['super_admin', 'admin', 'petugas'],
                            true
                        )
                        && $this->getOwnerRecord()->status_aduan === 'diajukan'
                    )
                    ->using(function (array $data): \Illuminate\Database\Eloquent\Model {
                        $user = Auth::user();

                        abort_unless(
                            $user !== null
                            && in_array(
                                $user->role,
                                ['super_admin', 'admin', 'petugas'],
                                true
                            ),
                            403
                        );

                        return DB::transaction(function () use ($data, $user) {
                            $complaint = Complaints::query()
                                ->lockForUpdate()
                                ->findOrFail($this->getOwnerRecord()->getKey());

                            if ($complaint->status_aduan !== 'diajukan') {
                                throw ValidationException::withMessages([
                                    'tanggapan' => 'Aduan sudah mendapatkan tanggapan atau tidak dapat ditanggapi saat ini.',
                                ]);
                            }

                            $cycle = $complaint->response_cycle;

                            if ($complaint->replays()
                                ->where('cycle_number', $cycle)
                                ->exists()) {
                                throw ValidationException::withMessages([
                                    'tanggapan' => 'Aduan sudah memiliki tanggapan pada siklus ini.',
                                ]);
                            }

                            $record = $complaint->replays()->create([
                                'tanggapan' => $data['tanggapan'],
                                'id_petugas' => $user->id,
                                'cycle_number' => $cycle,
                            ]);

                            $complaint->update([
                                'status_aduan' => 'ditanggapi',
                            ]);

                            $complaint->statusHistories()->create([
                                'user_id' => $user->id,
                                'old_status' => 'diajukan',
                                'new_status' => 'ditanggapi',
                                'notes' => null,
                            ]);

                            return $record;
                        });
                    })
                    ->after(function ($record, $livewire) {
                        $complaint = $livewire->getOwnerRecord();

                        $page = Auth::user()?->role === 'petugas'
                            ? 'view'
                            : 'edit';

                        $livewire->redirect(
                            ComplaintsResource::getUrl(
                                $page,
                                ['record' => $complaint->getKey()]
                            ),
                            navigate: true
                        );
                    }),
            ])
            ->recordActions([]);
    }
}
