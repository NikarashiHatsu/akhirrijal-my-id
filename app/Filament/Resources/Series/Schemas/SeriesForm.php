<?php

namespace App\Filament\Resources\Series\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SeriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Series')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Select::make('aspect_ratio')
                            ->required()
                            ->options([
                                '4/3' => '4/3 — landscape (wider)',
                                '3/4' => '3/4 — portrait',
                                '16/10' => '16/10 — cinematic',
                                '4/5' => '4/5 — tall portrait',
                            ])
                            ->default('4/3'),
                    ]),

                Section::make('Copy')
                    ->columns(1)
                    ->schema([
                        Textarea::make('lead')
                            ->rows(3)
                            ->helperText('Long sentence used on the series sub-hero and portfolio block.'),
                        Textarea::make('short_description')
                            ->rows(2)
                            ->helperText('Shorter version used on the home featured tiles.'),
                    ]),

                Section::make('Imagery')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('cover_image_path')
                            ->image()
                            ->imageEditor()
                            ->visibility('public')
                            ->directory('series'),
                        TextInput::make('cover_image_alt')->maxLength(255),
                        FileUpload::make('subhero_image_path')
                            ->image()
                            ->imageEditor()
                            ->visibility('public')
                            ->directory('series'),
                        TextInput::make('subhero_image_alt')->maxLength(255),
                    ]),
            ]);
    }
}
