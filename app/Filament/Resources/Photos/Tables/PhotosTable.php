<?php

namespace App\Filament\Resources\Photos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PhotosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('series_id')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('series.title')->label('Series')->badge()->sortable(),
                TextColumn::make('sort_order')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('location')->toggleable(),
                TextColumn::make('date_label')->label('Date')->toggleable(),
                TextColumn::make('ratio')->badge(),
            ])
            ->filters([
                SelectFilter::make('series')->relationship('series', 'title'),
                SelectFilter::make('ratio')->options([
                    'landscape' => 'Landscape',
                    'landscape4' => 'Landscape 4',
                    'portrait' => 'Portrait',
                    'tall' => 'Tall',
                    'square' => 'Square',
                    'pano' => 'Panoramic',
                ]),
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
