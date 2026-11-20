<?php

namespace App\Filament\Resources\Complaints\RelationManagers;

use App\Models\Complaints;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class ReplaysRelationManager extends RelationManager
{
    protected static string $relationship = 'replays';

    protected static ?string $recordTitleAttribute = 'tanggapan';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('tanggapan')
                ->label('Balasan Admin')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggapan')
                    ->label('Tanggapan')
                    ->limit(50),

                TextColumn::make('created_at')
                    ->label('Tanggal Balasan')
                    ->dateTime('d M Y H:i'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Balasan')
                    ->after(function ($livewire) {
                        $complaint = $livewire->getOwnerRecord();

                        $complaint->update([
                            'status_aduan' => 'ditindaklanjuti',
                        ]);

                        $livewire->redirect(
                            \App\Filament\Resources\Complaints\ComplaintsResource::getUrl(
                                'edit',
                                ['record' => $complaint->getKey()]
                            ),
                            navigate: true
                        );
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
