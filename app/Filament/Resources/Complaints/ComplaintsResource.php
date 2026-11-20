<?php

namespace App\Filament\Resources\Complaints;

use App\Filament\Resources\Complaints\Pages\CreateComplaints;
use App\Filament\Resources\Complaints\Pages\EditComplaints;
use App\Filament\Resources\Complaints\Pages\ListComplaints;
use App\Filament\Resources\Complaints\Schemas\ComplaintsForm;
use App\Filament\Resources\Complaints\Tables\ComplaintsTable;
use App\Filament\Resources\Complaints\RelationManagers\ReplaysRelationManager;
use App\Models\Complaints;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ComplaintsResource extends Resource
{
    protected static ?string $modelLabel = 'Aduan';

    protected static ?string $pluralModelLabel = 'Aduan';

    protected static ?string $navigationLabel = 'Aduan';

    protected static string|UnitEnum|null $navigationGroup = 'Aduan';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $model = Complaints::class;

    protected static ?string $recordTitleAttribute = 'no_aduan';

    public static function form(Schema $schema): Schema
    {
        return ComplaintsForm::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            ReplaysRelationManager::class,
        ];
    }

    public static function table(Table $table): Table
    {
        return ComplaintsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComplaints::route('/'),
            'create' => CreateComplaints::route('/create'),
            'edit' => EditComplaints::route('/{record}/edit'),
        ];
    }
}
