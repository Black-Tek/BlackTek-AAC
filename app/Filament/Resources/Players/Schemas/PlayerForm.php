<?php

namespace App\Filament\Resources\Players\Schemas;

use App\Models\Player;
use App\Models\Town;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('vocation')
                    ->options(app('vocations')->getAllVocations())
                    ->default(function (?Player $record) {
                        return $record ? $record->vocation : 0;
                    })
                    ->afterStateHydrated(function (Select $component, ?string $state) {
                        if ($state === null) {
                            $component->state($component->getDefaultState());
                        }
                    })
                    ->selectablePlaceholder(false)
                    ->required(),
                Select::make('town_id')
                    ->label('Town')
                    ->options(Town::all()->pluck('name', 'id'))
                    ->default(function (?Player $record) {
                        return $record ? $record->town_id : null;
                    })
                    ->afterStateHydrated(function (Select $component, ?string $state) {
                        if ($state === null) {
                            $component->state($component->getDefaultState());
                        }
                    })
                    ->required(),
                Select::make('sex')
                    ->options([
                        0 => 'Female',
                        1 => 'Male',
                    ])
                    ->required(),
                TextInput::make('level')
                    ->numeric()
                    ->default(1)
                    ->required(),
                TextInput::make('experience')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('looktype')
                    ->numeric()
                    ->default(128)
                    ->required(),
                TextInput::make('lookhead')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('lookbody')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('looklegs')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('lookfeet')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('lookaddons')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('lookmount')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
