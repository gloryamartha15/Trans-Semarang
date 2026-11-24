<?php

namespace App\Filament\Resources\Buses;

use App\Filament\Resources\Buses\Pages\CreateBuses;
use App\Filament\Resources\Buses\Pages\EditBuses;
use App\Filament\Resources\Buses\Pages\ListBuses;
use App\Filament\Resources\Buses\Schemas\BusesForm;
use App\Filament\Resources\Buses\Tables\BusesTable;
use App\Models\Buses;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BusesResource extends Resource
{
    protected static ?string $modelLabel = 'Bus';

    protected static ?string $pluralModelLabel = 'Bus';

    protected static ?string $model = Buses::class;

    protected static ?string $navigationLabel = 'Bus';

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $recordTitleAttribute = 'police_number';

    public static function form(Schema $schema): Schema
    {
        return BusesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BusesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBuses::route('/'),
            'create' => CreateBuses::route('/create'),
            'edit' => EditBuses::route('/{record}/edit'),
        ];
    }
}
