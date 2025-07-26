<?php

namespace App\Filament\Resources\Accounts\Tables;

use App\Models\Account;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type')
                    ->sortable()
                    ->badge(),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (Account $record) {
                        return $record->getPremiumStatus();
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Free Account' => 'danger',
                        default => 'success',
                    }),
                TextColumn::make('premium_ends_at')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (Account $record) {
                        return $record->getPremiumDate();
                    }),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('creation')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function (Account $record) {
                        return $record->getCreationDate();
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
