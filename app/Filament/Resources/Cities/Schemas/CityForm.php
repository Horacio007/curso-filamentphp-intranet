<?php

namespace App\Filament\Resources\Cities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('state_id')
                    ->required()
                    ->numeric(),
                TextInput::make('state_code')
                    ->required(),
                TextInput::make('geo_code')
                    ->required(),
                TextInput::make('city_code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
