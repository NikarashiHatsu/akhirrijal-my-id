<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Equipment card')
                    ->columns(2)
                    ->schema([
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('badge_label')
                            ->maxLength(255)
                            ->helperText('Top-left eyebrow inside the card (e.g. "DSLR · APS-C").'),
                        TextInput::make('badge_value')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Big display value inside the card (e.g. "60D", "50mm", "Ps").'),
                        TextInput::make('category_label')
                            ->maxLength(255)
                            ->helperText('Eyebrow above the card title (e.g. "Body", "Prime", "Finish").'),
                        Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
