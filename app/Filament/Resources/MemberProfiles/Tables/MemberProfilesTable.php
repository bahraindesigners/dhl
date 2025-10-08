<?php

namespace App\Filament\Resources\MemberProfiles\Tables;

use App\Models\MemberProfile;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MemberProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('employee_image')
                    ->label('Employee Photo')
                    ->collection('employee_image')
                    ->circular()
                    ->imageSize(50)
                    ->openUrlInNewTab(),

                SpatieMediaLibraryImageColumn::make('signature')
                    ->label('Signature')
                    ->collection('signature')
                    ->conversion('signature_thumb')
                    ->circular()
                    ->imageSize(50)
                    ->openUrlInNewTab(),

                IconColumn::make('withdrawal_letters')
                    ->label('Withdrawal Letter')
                    ->icon(fn ($record) => $record->hasMedia('withdrawal_letters') ? 'heroicon-o-document-text' : 'heroicon-o-x-mark')
                    ->color(fn ($record) => $record->hasMedia('withdrawal_letters') ? 'success' : 'gray')
                    ->tooltip(fn ($record) => $record->hasMedia('withdrawal_letters')
                        ? 'Withdrawal letter uploaded - '.$record->getFirstMedia('withdrawal_letters')?->name
                        : 'No withdrawal letter uploaded')
                    ->url(fn ($record) => $record->hasMedia('withdrawal_letters')
                        ? $record->getFirstMediaUrl('withdrawal_letters')
                        : null)
                    ->openUrlInNewTab()
                    ->toggleable(),

                TextColumn::make('staff_number')
                    ->label('Staff #')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable(['users.name'])
                    ->sortable(['users.name'])
                    ->weight('medium')
                    ->placeholder('No user linked'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(['users.email'])
                    ->sortable(['users.email'])
                    ->color('gray')
                    ->placeholder('No email')
                    ->toggleable(),

                TextColumn::make('cpr_number')
                    ->label('CPR')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('position')
                    ->label('Position')
                    ->searchable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('department')
                    ->label('Department')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('nationality')
                    ->label('Nationality')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('gender')
                    ->label('Gender')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('marital_status')
                    ->label('Marital Status')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('date_of_joining')
                    ->label('Joined')
                    ->date('M d, Y')
                    ->sortable()
                    ->color('success'),

                TextColumn::make('mobile_number')
                    ->label('Mobile')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->color('primary')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('profile_status')
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

                TextColumn::make('deleted_at')
                    ->label('Deleted')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('danger'),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->label('Department')
                    ->options(function () {
                        return MemberProfile::query()
                            ->distinct()
                            ->pluck('department', 'department')
                            ->toArray();
                    })
                    ->multiple(),

                SelectFilter::make('gender')
                    ->label('Gender')
                    ->options(MemberProfile::getGenderOptions())
                    ->multiple(),

                SelectFilter::make('marital_status')
                    ->label('Marital Status')
                    ->options(MemberProfile::getMaritalStatusOptions())
                    ->multiple(),

                SelectFilter::make('nationality')
                    ->label('Nationality')
                    ->options(MemberProfile::getNationalityOptions())
                    ->multiple(),

                SelectFilter::make('profile_status')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->recordUrl(
                fn (MemberProfile $record): string => route('filament.admin.resources.member-profiles.view', $record)
            );
    }
}
