<?php

namespace App\Filament\Resources\Stops;

use UnitEnum;
use App\Filament\Resources\Stops\Pages\CreateStops;
use App\Filament\Resources\Stops\Pages\EditStops;
use App\Filament\Resources\Stops\Pages\ListStops;
use App\Filament\Resources\Stops\Schemas\StopsForm;
use App\Filament\Resources\Stops\Tables\StopsTable;
use App\Models\Stops;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StopsResource extends Resource
{
    protected static ?string $modelLabel = 'Halte';

    protected static ?string $pluralModelLabel = 'Halte';

    protected static ?string $model = Stops::class;

    protected static ?string $navigationLabel = 'Halte';

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $recordTitleAttribute = 'Stops';

    public static function form(Schema $schema): Schema
    {
        return StopsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StopsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStops::route('/'),
            'create' => CreateStops::route('/create'),
            'edit' => EditStops::route('/{record}/edit'),
        ];
    }
}
