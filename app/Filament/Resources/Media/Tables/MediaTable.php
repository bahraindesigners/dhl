<?php

namespace App\Filament\Resources\Media\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MediaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('preview')
                    ->label('Preview')
                    ->getStateUsing(function ($record) {
                        if (str_starts_with($record->mime_type, 'image/')) {
                            return $record->getUrl();
                        }
                        return null;
                    })
                    ->imageSize(60)
                    ->circular(false),
                
                TextColumn::make('name')
                    ->label('File Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),
                
                TextColumn::make('collection_name')
                    ->label('Collection')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('mime_type')
                    ->label('Type')
                    ->badge()
                    ->searchable(),
                
                TextColumn::make('size')
                    ->label('Size')
                    ->getStateUsing(function ($record) {
                        return self::formatBytes($record->size);
                    })
                    ->sortable(),
                
                TextColumn::make('model_type')
                    ->label('Attached To')
                    ->getStateUsing(function ($record) {
                        if ($record->model) {
                            $modelName = class_basename($record->model_type);
                            return "{$modelName} #{$record->model_id}";
                        }
                        return 'Unattached';
                    })
                    ->badge()
                    ->color(fn ($state) => $state === 'Unattached' ? 'warning' : 'success'),
                
                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('collection_name')
                    ->label('Collection')
                    ->options(function () {
                        return \Spatie\MediaLibrary\MediaCollections\Models\Media::query()
                            ->distinct()
                            ->pluck('collection_name', 'collection_name')
                            ->filter()
                            ->toArray();
                    }),
                
                SelectFilter::make('mime_type')
                    ->label('File Type')
                    ->options([
                        'image/jpeg' => 'JPEG Image',
                        'image/png' => 'PNG Image',
                        'image/gif' => 'GIF Image',
                        'image/webp' => 'WebP Image',
                        'image/svg+xml' => 'SVG Image',
                        'application/pdf' => 'PDF Document',
                        'video/mp4' => 'MP4 Video',
                        'video/webm' => 'WebM Video',
                        'audio/mpeg' => 'MP3 Audio',
                        'audio/wav' => 'WAV Audio',
                        'text/plain' => 'Text File',
                    ]),
                
                SelectFilter::make('attachment_status')
                    ->label('Attachment Status')
                    ->options([
                        'attached' => 'Attached to Model',
                        'unattached' => 'Unattached',
                    ])
                    ->query(function ($query, $data) {
                        if ($data['value'] === 'attached') {
                            return $query->whereNotNull('model_type');
                        } elseif ($data['value'] === 'unattached') {
                            return $query->whereNull('model_type');
                        }
                        return $query;
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make()
                    ->label('View')
                    ->url(fn ($record) => $record->getUrl())
                    ->openUrlInNewTab(),
                
                DeleteAction::make()
                    ->label('Delete')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Media File')
                    ->modalDescription('Are you sure you want to delete this media file? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete it')
                    ->action(function ($record) {
                        // Delete the physical file
                        if (file_exists($record->getPath())) {
                            unlink($record->getPath());
                        }
                        
                        // Remove empty directory
                        $dir = dirname($record->getPath());
                        if (file_exists($dir) && count(scandir($dir)) == 2) {
                            rmdir($dir);
                        }
                        
                        // Delete the database record
                        $record->delete();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Media Files')
                        ->modalDescription('Are you sure you want to delete the selected media files? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete them')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                // Delete the physical file
                                if (file_exists($record->getPath())) {
                                    unlink($record->getPath());
                                }
                                
                                // Remove empty directory
                                $dir = dirname($record->getPath());
                                if (file_exists($dir) && count(scandir($dir)) == 2) {
                                    rmdir($dir);
                                }
                                
                                // Delete the database record
                                $record->delete();
                            }
                        }),
                ]),
            ]);
    }
    
    private static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
