<?php

namespace App\Filament\Resources\Buses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use LaraZeus\Qr\Components\Qr;

class BusesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('police_number')
                    ->required(),      
                Qr::make('qr_code')
                ->uploadDisk('public')
                ->dehydrateStateUsing(
                fn ($state) => is_array($state)
                ? ($state['qr_code'] ?? null)
                : $state
                )
                ->required(),
                TextInput::make('bus_number')
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
