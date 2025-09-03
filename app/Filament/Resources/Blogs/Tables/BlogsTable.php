<?php

namespace App\Filament\Resources\Blogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BlogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('featured_image'))
                    ->imageSize(50)
                    
                    ->defaultImageUrl(url('/logo.svg'))
                    ->extraImgAttributes([
                        'loading' => 'lazy',
                        'class' => 'object-cover rounded',
                    ]),

                TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn ($record) => $record->getTranslation('title', 'en') ?: $record->getTranslation('title', 'ar'))
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->getStateUsing(fn ($record) => $record->category?->getTranslation('name', 'en') ?: $record->category?->getTranslation('name', 'ar'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'primary' => 'scheduled',
                        'danger' => 'archived',
                    ])
                    ->searchable(),

                IconColumn::make('featured')
                    ->boolean()
                    ->label('Featured')
                     ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('author')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('reading_time')
                    ->label('Reading Time')
                    ->formatStateUsing(fn ($state) => $state ? $state . ' min' : 'Auto')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                        'archived' => 'Archived',
                    ]),
                
                SelectFilter::make('blog_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', 'en') ?: $record->getTranslation('name', 'ar')),
                
                SelectFilter::make('featured')
                    ->options([
                        true => 'Featured',
                        false => 'Not Featured',
                    ])
                    ->label('Featured Status'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
