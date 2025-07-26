<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->maxLength(255),

                    Grid::make(2)
                        ->schema([
                            DateTimePicker::make('published_at')
                                ->label('Published At')
                                ->required(),
                            Toggle::make('is_published')
                                ->label('Published')
                                ->required()
                                ->inline(false)
                                ->helperText('Enable this to make the news visible to users.'),
                        ]),
                    RichEditor::make('content')
                        ->label('Content')
                        ->required()
                        ->columnSpanFull(),
                ])
                    ->columns(1)
                    ->columnSpanFull(),
            ]);
    }
}
