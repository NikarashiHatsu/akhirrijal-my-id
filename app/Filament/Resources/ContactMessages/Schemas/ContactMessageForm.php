<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sender')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')->disabled(),
                        TextInput::make('email')->disabled(),
                        TextInput::make('subject')->disabled()->columnSpanFull(),
                    ]),

                Section::make('Message')
                    ->schema([
                        Textarea::make('message')->disabled()->rows(8),
                    ]),

                Section::make('Request')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextInput::make('ip_address')->label('IP address')->disabled(),
                        TextInput::make('user_agent')->disabled()->columnSpanFull(),
                    ]),

                Section::make('Reply tracking')
                    ->columns(1)
                    ->schema([
                        DateTimePicker::make('replied_at')
                            ->native(false)
                            ->helperText('Set when you have followed up with the sender.'),
                    ]),
            ]);
    }
}
