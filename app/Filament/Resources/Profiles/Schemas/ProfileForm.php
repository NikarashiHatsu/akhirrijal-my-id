<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identity')
                    ->description('Who you are — used in the hero, navigation, and JSON-LD.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('alternate_name')
                            ->maxLength(255),
                        TextInput::make('monogram')
                            ->helperText('Display name in the navigation logo (e.g. "Akhirrijal").')
                            ->maxLength(255),
                        TextInput::make('job_title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('tagline')
                            ->columnSpanFull()
                            ->maxLength(255),
                        TextInput::make('specializations')
                            ->columnSpanFull()
                            ->helperText('Eyebrow strip under the hero headline.')
                            ->maxLength(255),
                    ]),

                Section::make('Home page copy')
                    ->description('Headlines and lead text shown on the home page.')
                    ->columns(1)
                    ->schema([
                        Textarea::make('hero_lead')
                            ->rows(2)
                            ->helperText('Lead paragraph beneath the hero headline.'),
                        TextInput::make('home_about_heading')
                            ->helperText('About section heading on the home page.')
                            ->maxLength(255),
                        Textarea::make('home_selected_work_heading')
                            ->rows(2)
                            ->helperText('Selected work section heading. Use a blank line for a line break.'),
                    ]),

                Section::make('Story')
                    ->columns(1)
                    ->schema([
                        Textarea::make('bio')
                            ->rows(10)
                            ->helperText('Use a blank line between paragraphs.'),
                        Textarea::make('statement')
                            ->rows(3)
                            ->helperText('Pull-quote used on the home manifesto block.'),
                    ]),

                Section::make('Location & availability')
                    ->columns(3)
                    ->schema([
                        TextInput::make('location_city')->maxLength(255),
                        TextInput::make('location_country')->maxLength(255),
                        TextInput::make('availability_status')->maxLength(255),
                    ]),

                Section::make('Contact channels')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')->email()->maxLength(255),
                        TextInput::make('whatsapp_e164')
                            ->label('WhatsApp (E.164, digits only)')
                            ->maxLength(255),
                        TextInput::make('whatsapp_display')
                            ->label('WhatsApp (display)')
                            ->maxLength(255),
                        TextInput::make('instagram_handle')->maxLength(255),
                        TextInput::make('instagram_url')->url()->maxLength(255),
                        TextInput::make('website_url')->url()->maxLength(255),
                    ]),

                Section::make('Page imagery')
                    ->description('Hero and sub-hero images used on the home, about, portfolio, and contact pages.')
                    ->columns(2)
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('hero_image_path')
                                ->label('Home hero')
                                ->image()
                                ->imageEditor()
                                ->visibility('public')
                                ->directory('profile')
                                ->columnSpan(1),
                            TextInput::make('hero_image_alt')
                                ->label('Home hero alt')
                                ->maxLength(255)
                                ->columnSpan(1),

                            FileUpload::make('about_portrait_image_path')
                                ->label('About portrait')
                                ->image()
                                ->imageEditor()
                                ->visibility('public')
                                ->directory('profile')
                                ->columnSpan(1),
                            TextInput::make('about_portrait_image_alt')
                                ->label('About portrait alt')
                                ->maxLength(255)
                                ->columnSpan(1),

                            FileUpload::make('about_subhero_image_path')
                                ->label('About sub-hero')
                                ->image()
                                ->imageEditor()
                                ->visibility('public')
                                ->directory('profile')
                                ->columnSpan(1),
                            TextInput::make('about_subhero_image_alt')
                                ->label('About sub-hero alt')
                                ->maxLength(255)
                                ->columnSpan(1),

                            FileUpload::make('portfolio_subhero_image_path')
                                ->label('Portfolio sub-hero')
                                ->image()
                                ->imageEditor()
                                ->visibility('public')
                                ->directory('profile')
                                ->columnSpan(1),
                            TextInput::make('portfolio_subhero_image_alt')
                                ->label('Portfolio sub-hero alt')
                                ->maxLength(255)
                                ->columnSpan(1),

                            FileUpload::make('contact_subhero_image_path')
                                ->label('Contact sub-hero')
                                ->image()
                                ->imageEditor()
                                ->visibility('public')
                                ->directory('profile')
                                ->columnSpan(1),
                            TextInput::make('contact_subhero_image_alt')
                                ->label('Contact sub-hero alt')
                                ->maxLength(255)
                                ->columnSpan(1),
                        ])->columnSpanFull(),
                    ]),

                Section::make('Footer')
                    ->columns(1)
                    ->schema([
                        TextInput::make('crafted_in_label')->maxLength(255),
                    ]),
            ]);
    }
}
