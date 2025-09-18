<?php

namespace App\Filament\Resources\BoardMembers\Tables;

use App\Models\BoardMember;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BoardMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->label('Avatar')
                    ->collection('avatar')
                    ->conversion('thumb')
                    ->circular()
                    ->defaultImageUrl('/images/default-avatar.png')
                    ->size(50),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->formatStateUsing(function ($state, BoardMember $record) {
                        // Get current locale from various possible sources
                        $locale = request()->get('locale') 
                               ?? session()->get('locale') 
                               ?? app()->getLocale() 
                               ?? 'en';
                        
                        return $record->getTranslation('name', $locale);
                    }),

                TextColumn::make('position')
                    ->label('Position')
                    ->searchable()
                    ->sortable()
                    ->color('primary')
                    ->formatStateUsing(function ($state, BoardMember $record) {
                        // Get current locale from various possible sources
                        $locale = request()->get('locale') 
                               ?? session()->get('locale') 
                               ?? app()->getLocale() 
                               ?? 'en';
                        
                        return $record->getTranslation('position', $locale);
                    }),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column, BoardMember $record): ?string {
                        $locale = request()->get('locale') 
                               ?? session()->get('locale') 
                               ?? app()->getLocale() 
                               ?? 'en';
                        
                        $state = $record->getTranslation('description', $locale);

                        if (strlen($state) <= 50) {
                            return null;
                        }

                        return strip_tags($state);
                    })
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(function ($state, BoardMember $record) {
                        $locale = request()->get('locale') 
                               ?? session()->get('locale') 
                               ?? app()->getLocale() 
                               ?? 'en';
                        
                        $translatedState = $record->getTranslation('description', $locale);
                        return strip_tags($translatedState); // Remove HTML tags for table display
                    }),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->recordActions([
                // ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->searchable();
            // ->recordUrl(
            //     fn (BoardMember $record): string => route('filament.admin.resources.board-members.view', $record)
            // );
    }
}
