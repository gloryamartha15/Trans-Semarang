<?php

namespace App\Filament\Resources\Routes\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RouteStopsRelationManager extends RelationManager
{
    protected static string $relationship = 'routeStops';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('stop_id')
                    ->label('Pilih Halte')
                    ->relationship(
                        name: 'stop',
                        titleAttribute: 'name_stop'
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Hidden::make('stop_order')
                    ->default(
                        fn () => (int) $this->getOwnerRecord()
                            ->routeStops()
                            ->max('stop_order') + 1
                    ),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('stop_id')
            ->columns([

                TextColumn::make('stop_order')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('stop.stops_number')
                    ->label('Nomor Halte')
                    ->searchable(),

                TextColumn::make('stop.name_stop')
                    ->label('Nama Halte')
                    ->searchable(),

            ])
            ->defaultSort('stop_order')
            ->reorderable('stop_order')
            ->headerActions([

                CreateAction::make()
                    ->label('Tambah Halte')
                    ->schema([
                        Select::make('stop_id')
                            ->label('Pilih Halte')
                            ->relationship(
                                name: 'stop',
                                titleAttribute: 'name_stop',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->whereDoesntHave(
                                        'routes',
                                        fn (Builder $routeQuery) => $routeQuery
                                            ->whereKey($this->getOwnerRecord()->getKey())
                                    ),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Hidden::make('stop_order')
                            ->default(
                                fn () => (int) $this->getOwnerRecord()
                                    ->routeStops()
                                    ->max('stop_order') + 1
                            ),
                    ]),

            ])
            ->recordActions([
                EditAction::make()
                    ->label('Ubah'),

                DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
