<?php

namespace App\Filament\Resources\States\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('geo_code')
                    ->required(),
                TextInput::make('state_code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('abbreviation')
                    ->required(),
            ]);
    }
}
