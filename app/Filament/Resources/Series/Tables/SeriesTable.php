<?php

namespace App\Filament\Resources\Series\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('cover_image_path')
                    ->label('Cover')
                    ->disk('public')
                    ->square(),
                TextColumn::make('sort_order')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('slug')->badge(),
                TextColumn::make('aspect_ratio')->badge(),
                TextColumn::make('photos_count')
                    ->label('Photos')
                    ->counts('photos'),
                TextColumn::make('updated_at')->dateTime()->since()->sortable(),
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
