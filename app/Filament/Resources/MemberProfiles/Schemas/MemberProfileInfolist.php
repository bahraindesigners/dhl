<?php

namespace App\Filament\Resources\MemberProfiles\Schemas;

use App\Filament\Infolists\Components\MediaFileEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MemberProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Member Profile')
                    ->tabs([
                        Tab::make('Personal Information')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        // User Association Section
                                        Section::make('User Account')
                                            ->icon('heroicon-o-user-circle')
                                            ->description('Associated user account for this profile')
                                            ->schema([
                                                TextEntry::make('user.name')
                                                    ->label('User Name')
                                                    ->icon('heroicon-o-user')
                                                    ->columnSpanFull(),

                                                TextEntry::make('user.email')
                                                    ->label('Email Address')
                                                    ->icon('heroicon-o-envelope')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull()
                                            ->collapsible(),


                                        // Employee Image Section
                                        Section::make('Employee Photo')
                                            ->icon('heroicon-o-camera')
                                            ->description('Employee identification photo')
                                            ->schema([
                                                SpatieMediaLibraryImageEntry::make('employee_image')
                                                    ->label('Employee Photo')
                                                    ->collection('employee_image')
                                                    ->imageSize(150)
                                                    ->circular()
                                                    ->url(fn($record) => $record->getFirstMediaUrl('employee_image') ?: null)
                                                    ->openUrlInNewTab()
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpan(2)
                                            ->collapsible(),

                                        // Signature Section
                                        Section::make('Digital Signature')
                                            ->icon('heroicon-o-pencil')
                                            ->description('Member signature for forms')
                                            ->schema([
                                                SpatieMediaLibraryImageEntry::make('signature')
                                                    ->label('Signature Image')
                                                    ->collection('signature')
                                                    ->imageSize(150)
                                                    ->circular()
                                                    ->url(fn($record) => $record->getFirstMediaUrl('signature') ?: null)
                                                    ->openUrlInNewTab()
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpan(2)
                                            ->collapsible(),

                                        // Basic Information
                                        Section::make('Basic Details')
                                            ->icon('heroicon-o-identification')
                                            ->description('Essential identification information')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextEntry::make('cpr_number')
                                                            ->label('CPR Number')
                                                            ->icon('heroicon-o-identification')
                                                            ->columnSpan(1),

                                                        TextEntry::make('staff_number')
                                                            ->label('Staff Number')
                                                            ->icon('heroicon-o-tag')
                                                            ->formatStateUsing(fn($state) => 'EMP-' . $state)
                                                            ->columnSpan(1),
                                                    ]),
                                            ])
                                            ->columnSpan(2),
                                        // Personal Details Section
                                        Section::make('Personal Details')
                                            ->icon('heroicon-o-users')
                                            ->description('Personal and demographic information')
                                            ->schema([
                                                Grid::make(4)
                                                    ->schema([
                                                        TextEntry::make('nationality')
                                                            ->label('Nationality')
                                                            ->icon('heroicon-o-flag')
                                                            ->columnSpan(1),

                                                        TextEntry::make('gender')
                                                            ->label('Gender')
                                                            ->icon('heroicon-o-user-circle')
                                                            ->formatStateUsing(fn($state) => ucfirst($state))
                                                            ->columnSpan(1),

                                                        TextEntry::make('marital_status')
                                                            ->label('Marital Status')
                                                            ->icon('heroicon-o-heart')
                                                            ->formatStateUsing(fn($state) => ucfirst(str_replace('_', ' ', $state)))
                                                            ->columnSpan(1),
                                                    ]),
                                            ])
                                            ->collapsible()
                                            ->columnSpan(2),
                                    ]),
                            ]),



                        Tab::make('Employment Details')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        // Employment Information
                                        Section::make('Employment Information')
                                            ->icon('heroicon-o-briefcase')
                                            ->description('Job position and department details')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextEntry::make('date_of_joining')
                                                            ->label('Date of Joining')
                                                            ->icon('heroicon-o-calendar-days')
                                                            ->date('d/m/Y')
                                                            ->columnSpan(2),

                                                        TextEntry::make('position')
                                                            ->label('Position/Job Title')
                                                            ->icon('heroicon-o-user-circle')
                                                            ->columnSpan(1),

                                                        TextEntry::make('department')
                                                            ->label('Department')
                                                            ->icon('heroicon-o-building-office-2')
                                                            ->columnSpan(1),

                                                        TextEntry::make('section')
                                                            ->label('Section/Unit')
                                                            ->icon('heroicon-o-squares-2x2')
                                                            ->placeholder('Not specified')
                                                            ->columnSpan(2),

                                                        TextEntry::make('office_phone')
                                                            ->label('Office Phone')
                                                            ->icon('heroicon-o-phone')
                                                            ->placeholder('Not provided')
                                                            ->columnSpan(1),

                                                        TextEntry::make('education_qualification')
                                                            ->label('Education Qualification')
                                                            ->icon('heroicon-o-academic-cap')
                                                            ->formatStateUsing(fn($state) => ucfirst(str_replace('_', ' ', $state)))
                                                            ->columnSpan(1),
                                                    ]),
                                            ])
                                            ->columnSpan(1),

                                        // Work Location
                                        Section::make('Work Location')
                                            ->icon('heroicon-o-map-pin')
                                            ->description('Office address and location details')
                                            ->schema([
                                                TextEntry::make('working_place_address')
                                                    ->label('Office Address')
                                                    ->placeholder('No address provided')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpan(1),
                                    ]),
                            ]),

                        Tab::make('Contact Information')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Section::make('Contact Details')
                                    ->icon('heroicon-o-phone')
                                    ->description('Personal contact information')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('mobile_number')
                                                    ->label('Mobile Number')
                                                    ->icon('heroicon-o-device-phone-mobile')
                                                    ->placeholder('Not provided')
                                                    ->columnSpan(1),

                                                TextEntry::make('home_phone')
                                                    ->label('Home Phone')
                                                    ->icon('heroicon-o-phone')
                                                    ->placeholder('Not provided')
                                                    ->columnSpan(1),
                                            ]),

                                        TextEntry::make('permanent_address')
                                            ->label('Permanent Address')
                                            ->placeholder('No address provided')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Documents & Files')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                

                                Section::make('Withdrawal Letters')
                                    ->icon('heroicon-o-document-text')
                                    ->description('Member withdrawal letters and related documents')
                                    ->schema([
                                        MediaFileEntry::make('withdrawal_letters')
                                            ->label('Withdrawal Letters')
                                            ->collection('withdrawal_letters')
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),

                                
                            ]),

                        Tab::make('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Section::make('Profile Status')
                                    ->icon('heroicon-o-shield-check')
                                    ->description('Profile availability and status')
                                    ->schema([
                                        TextEntry::make('profile_status')
                                            ->label('Active Profile')
                                            ->formatStateUsing(fn($state) => $state ? 'Active' : 'Inactive')
                                            ->badge()
                                            ->color(fn($state) => $state ? 'success' : 'danger'),

                                        TextEntry::make('created_at')
                                            ->label('Profile Created')
                                            ->dateTime('M d, Y H:i'),

                                        TextEntry::make('updated_at')
                                            ->label('Last Updated')
                                            ->dateTime('M d, Y H:i'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
