<?php

namespace App\Filament\Resources\Petugas;

use App\Models\User;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;

class PetugasResource extends Resource
{
    protected static ?string $modelLabel = 'Petugas';

    protected static ?string $pluralModelLabel = 'Petugas';

    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Petugas';

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('role', 'petugas');
    }

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return \App\Filament\Resources\Petugas\Schemas\PetugasForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return \App\Filament\Resources\Petugas\Tables\PetugasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Petugas\Pages\ListPetugas::route('/'),
            'create' => \App\Filament\Resources\Petugas\Pages\CreatePetugas::route('/create'),
            'edit' => \App\Filament\Resources\Petugas\Pages\EditPetugas::route('/{record}/edit'),
        ];
    }
}