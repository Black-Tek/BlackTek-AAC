<?php

namespace App\Filament\Resources\Accounts\RelationManagers;

use App\Filament\Resources\Players\Schemas\PlayerForm;
use App\Filament\Resources\Players\Tables\PlayersTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    public function form(Schema $schema): Schema
    {
        return PlayerForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return PlayersTable::configure($table);
    }
}
