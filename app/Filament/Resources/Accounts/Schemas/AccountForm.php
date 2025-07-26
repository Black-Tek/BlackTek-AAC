<?php

namespace App\Filament\Resources\Accounts\Schemas;

use App\Enums\AccountType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('secret')
                    ->default(null),
                Select::make('type')
                    ->options(AccountType::class)
                    ->default(1)
                    ->required(),
                TextInput::make('premium_ends_at')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->default(''),
                TextInput::make('creation')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
