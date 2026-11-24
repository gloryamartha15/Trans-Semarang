<?php

namespace App\Filament\Resources\Routes;

use App\Filament\Resources\Routes\Pages\CreateRoutes;
use App\Filament\Resources\Routes\Pages\EditRoutes;
use App\Filament\Resources\Routes\Pages\ListRoutes;
use App\Filament\Resources\Routes\Pages\ViewRoutes;
use App\Filament\Resources\Routes\Schemas\RoutesForm;
use App\Filament\Resources\Routes\Tables\RoutesTable;
use App\Filament\Resources\Routes\RelationManagers\RouteStopsRelationManager;
use App\Models\Routes;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class RoutesResource extends Resource
{
    protected static ?string $navigationLabel = 'Rute';

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 2;

    protected static ?string $model = Routes::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static ?string $recordTitleAttribute = 'route_name';

    public static function canViewAny(): bool
    {
        $user = Auth::user();

        return $user instanceof User
            && $user->hasPermissionTo('ViewAny:Routes', 'admin');
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();

        return $user instanceof User
            && $user->hasPermissionTo('Create:Routes', 'admin');
    }

    public static function canEdit(Model $record): bool
    {
        $user = Auth::user();

        return $user instanceof User
            && $user->hasPermissionTo('Update:Routes', 'admin');
    }

    public static function canView(Model $record): bool
    {
        $user = Auth::user();

        return $user instanceof User
            && $user->hasPermissionTo('View:Routes', 'admin');
    }

    public static function canDelete(Model $record): bool
    {
        $user = Auth::user();

        return $user instanceof User
            && $user->hasPermissionTo('Delete:Routes', 'admin');
    }

    public static function form(Schema $schema): Schema
    {
        return RoutesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoutesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RouteStopsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoutes::route('/'),
            'create' => CreateRoutes::route('/create'),
            'view' => ViewRoutes::route('/{record}'),
            'edit' => EditRoutes::route('/{record}/edit'),
        ];
    }
}
