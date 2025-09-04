<?php

namespace App\Filament\Resources\Downloads\Tables;

use App\Models\Download;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class DownloadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('file_preview')
                    ->label('Preview')
                    ->getStateUsing(function (Download $record): ?string {
                        if ($record->hasFile()) {
                            $media = $record->getFirstMedia('downloads');
                            if ($media && str_starts_with($media->mime_type, 'image/')) {
                                return $media->getUrl('thumb');
                            }
                        }

                        return null;
                    })
                    ->defaultImageUrl('/images/file-icon.png')
                    ->size(60)
                    ->square(),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->description(fn (Download $record): ?string => $record->description)
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->colors([
                        'primary' => 'forms',
                        'success' => 'policies',
                        'warning' => 'handbooks',
                        'info' => 'training',
                        'secondary' => 'reports',
                        'gray' => 'guides',
                        'purple' => 'templates',
                        'orange' => 'other',
                    ])
                    ->sortable(),

                TextColumn::make('access_level')
                    ->label('Access Level')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'public' => 'Public',
                        'employees' => 'Employees',
                        'managers' => 'Managers',
                        'admin' => 'Admin',
                        default => ucfirst($state),
                    })
                    ->colors([
                        'success' => 'public',
                        'primary' => 'employees',
                        'warning' => 'managers',
                        'danger' => 'admin',
                    ])
                    ->sortable(),

                TextColumn::make('file_info')
                    ->label('File Info')
                    ->getStateUsing(function (Download $record): string {
                        if (! $record->hasFile()) {
                            return 'No file';
                        }

                        $fileName = $record->getFileName() ?? 'Unknown';
                        $fileSize = $record->getFileSizeFormatted();
                        $extension = $record->getFileExtension();

                        return $fileName.($extension ? ".{$extension}" : '')." ({$fileSize})";
                    })
                    ->description(fn (Download $record): ?string => $record->file_type)
                    ->wrap(),

                TextColumn::make('download_count')
                    ->label('Downloads')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'forms' => 'Forms & Documents',
                        'policies' => 'Policies & Procedures',
                        'handbooks' => 'Employee Handbooks',
                        'training' => 'Training Materials',
                        'reports' => 'Reports & Analytics',
                        'guides' => 'User Guides',
                        'templates' => 'Templates',
                        'other' => 'Other Resources',
                    ]),

                SelectFilter::make('access_level')
                    ->options([
                        'public' => 'Public Access',
                        'employees' => 'Employees Only',
                        'managers' => 'Managers Only',
                        'admin' => 'Admin Only',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only')
                    ->native(false),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->action(function (Download $record) {
                        if ($record->hasFile()) {
                            $record->incrementDownloadCount();

                            return response()->download($record->getFileUrl());
                        }
                    })
                    ->visible(fn (Download $record) => $record->hasFile())
                    ->openUrlInNewTab(),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->poll('60s') // Refresh every 60 seconds to update download counts
            ->emptyStateHeading('No downloads yet')
            ->emptyStateDescription('Start by creating your first download item.')
            ->emptyStateIcon('heroicon-o-document-arrow-down');
    }
}
