<?php

namespace App\Filament\Resources\ComplaintsReplays;

use App\Filament\Resources\ComplaintsReplays\Pages\ListComplaintsReplays;
use App\Filament\Resources\ComplaintsReplays\Tables\ComplaintsReplaysTable;
use App\Models\ComplaintsReplay;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ComplaintsReplayResource extends Resource
{
    protected static ?string $modelLabel = 'Tanggapan Aduan';

    protected static ?string $pluralModelLabel = 'Tanggapan Aduan';

    protected static ?string $navigationLabel = 'Tanggapan';

    protected static string|UnitEnum|null $navigationGroup = 'Aduan';

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $model = ComplaintsReplay::class;

    protected static ?string $recordTitleAttribute = 'tanggapan';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return ComplaintsReplaysTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComplaintsReplays::route('/'),
        ];
    }
}
