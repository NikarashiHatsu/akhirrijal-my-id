<?php

namespace App\Filament\Resources\SocialLinks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Footer link')
                    ->columns(2)
                    ->schema([
                        Select::make('platform')
                            ->required()
                            ->options([
                                'email' => 'Email',
                                'whatsapp' => 'WhatsApp',
                                'instagram' => 'Instagram',
                                'website' => 'Website',
                                'other' => 'Other',
                            ]),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('label')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Visible text in the footer (e.g. "Instagram · @senandung_hujan").'),
                        TextInput::make('url')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
