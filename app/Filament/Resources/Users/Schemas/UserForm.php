<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\State;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Builder;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Info')
                ->columnSpanFull()
                ->columns(3)
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->label('Email address')
                        ->email()
                        ->required(),
                    TextInput::make('password')
                        ->hidden('edit')
                        ->password()
                        ->required(),
                ]),
                Section::make('Adddress Info')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        Select::make('state_id')
                            ->label('Estado')
                            ->options(State::all()->pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
                            ->dehydrated(false)
                            ->required()
                            ->afterStateHydrated(function (Set $set, $record) {
                                // Si el usuario existe y tiene una ciudad cargada
                                if ($record && $record->city) {
                                    $set('state_id', $record->city->state_id);
                                }
                            }),
                        Select::make('city_id')
                            ->label('Ciudad')
                            ->relationship(
                                name: 'city',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query, Get $get) =>
                                    $query->where('state_id', $get('state_id'))
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->disabled(fn (Get $get) => !$get('state_id')),
                        TextInput::make('address')
                            ->required(),
                        TextInput::make('postal_code')
                            ->required(),
                    ])
            ]);
    }
}
