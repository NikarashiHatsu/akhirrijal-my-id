<?php

namespace App\Filament\Resources\Photos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PhotoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Frame')
                    ->columns(2)
                    ->schema([
                        Select::make('series_id')
                            ->relationship('series', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('story')
                            ->rows(5)
                            ->columnSpanFull(),
                        TextInput::make('alt')
                            ->label('Alt text (accessibility)')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('location')->maxLength(255),
                        TextInput::make('date_label')
                            ->maxLength(255)
                            ->helperText('Display label, e.g. "September 2024".'),
                        DatePicker::make('taken_at')->native(false),
                        Select::make('ratio')
                            ->required()
                            ->default('landscape')
                            ->options([
                                'landscape' => 'Landscape (3:2)',
                                'landscape4' => 'Landscape 4 (4:3)',
                                'portrait' => 'Portrait (2:3)',
                                'tall' => 'Tall (4:5)',
                                'square' => 'Square (1:1)',
                                'pano' => 'Panoramic (2:1)',
                            ])
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $dimensions = match ($state) {
                                    'landscape' => [1600, 1067],
                                    'landscape4' => [1600, 1200],
                                    'portrait' => [1067, 1600],
                                    'tall' => [1280, 1600],
                                    'square' => [1400, 1400],
                                    'pano' => [1800, 900],
                                    default => null,
                                };

                                if ($dimensions !== null) {
                                    [$width, $height] = $dimensions;
                                    $set('width', $width);
                                    $set('height', $height);
                                }
                            }),
                    ]),

                Section::make('Image')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image_path')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->visibility('public')
                            ->directory('photos')
                            ->columnSpanFull(),
                        Hidden::make('disk')->default('public'),
                        TextInput::make('width')->numeric(),
                        TextInput::make('height')->numeric(),
                    ]),
            ]);
    }
}
