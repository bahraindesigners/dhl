<?php

namespace App\Filament\Resources\MemberProfiles\Schemas;

use App\Models\MemberProfile;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MemberProfileForm
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
                                Grid::make(3)
                                    ->schema([
                                        // User Association Section
                                        Section::make('User Account')
                                            ->icon('heroicon-o-user-circle')
                                            ->description('Select the user account for this profile')
                                            ->schema([
                                                Select::make('user_id')
                                                    ->label('User Account')
                                                    ->options(User::pluck('name', 'id'))
                                                    ->searchable()
                                                    ->preload()
                                                    ->required()
                                                    ->prefixIcon('heroicon-o-user')
                                                    ->helperText('The name and email will be taken from the selected user account')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull()
                                            ->collapsible(),

                                        // Profile Photo Section
                                        Section::make('Profile Photo')
                                            ->icon('heroicon-o-camera')
                                            ->description('Upload member profile photo')
                                            ->schema([
                                                SpatieMediaLibraryFileUpload::make('profile_photo')
                                                    ->label('Profile Photo')
                                                    ->collection('profile_photo')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->imageEditorAspectRatios(['1:1'])
                                                    ->maxSize(2048)
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                                    ->avatar()
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpan(1)
                                            ->collapsible(),

                                        // Basic Information
                                        Section::make('Basic Details')
                                            ->icon('heroicon-o-identification')
                                            ->description('Essential identification information')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('cpr_number')
                                                            ->label('CPR Number')
                                                            ->required()
                                                            ->length(9)
                                                            ->numeric()
                                                            ->rule('regex:/^\d{9}$/')
                                                            ->unique(ignoreRecord: true)
                                                            ->helperText('Must be exactly 9 digits')
                                                            ->prefixIcon('heroicon-o-identification')
                                                            ->columnSpan(1),

                                                        TextInput::make('staff_number')
                                                            ->label('Staff Number')
                                                            ->required()
                                                            ->maxLength(20)
                                                            ->unique(ignoreRecord: true)
                                                            ->prefix('EMP-')
                                                            ->prefixIcon('heroicon-o-tag')
                                                            ->columnSpan(2),
                                                    ]),
                                            ])
                                            ->columnSpan(2),
                                    ]),

                                // Personal Details Section
                                Section::make('Personal Details')
                                    ->icon('heroicon-o-users')
                                    ->description('Personal and demographic information')
                                    ->schema([
                                        Grid::make(4)
                                            ->schema([
                                                Select::make('nationality')
                                                    ->label('Nationality')
                                                    ->required()
                                                    ->options(MemberProfile::getNationalityOptions())
                                                    ->searchable()
                                                    ->prefixIcon('heroicon-o-flag')
                                                    ->columnSpan(2),

                                                Select::make('gender')
                                                    ->label('Gender')
                                                    ->required()
                                                    ->options(MemberProfile::getGenderOptions())
                                                    ->prefixIcon('heroicon-o-user-circle')
                                                    ->columnSpan(1),

                                                Select::make('marital_status')
                                                    ->label('Marital Status')
                                                    ->required()
                                                    ->options(MemberProfile::getMaritalStatusOptions())
                                                    ->prefixIcon('heroicon-o-heart')
                                                    ->columnSpan(1),
                                            ]),
                                    ])
                                    ->collapsible(),
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
                                                        DatePicker::make('date_of_joining')
                                                            ->label('Date of Joining')
                                                            ->required()
                                                            ->maxDate(now())
                                                            ->displayFormat('d/m/Y')
                                                            ->prefixIcon('heroicon-o-calendar-days')
                                                            ->columnSpan(2),

                                                        TextInput::make('position')
                                                            ->label('Position/Job Title')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->prefixIcon('heroicon-o-user-circle')
                                                            ->columnSpan(1),

                                                        TextInput::make('department')
                                                            ->label('Department')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->prefixIcon('heroicon-o-building-office-2')
                                                            ->columnSpan(1),

                                                        TextInput::make('section')
                                                            ->label('Section/Unit')
                                                            ->maxLength(255)
                                                            ->prefixIcon('heroicon-o-squares-2x2')
                                                            ->columnSpan(2),

                                                        TextInput::make('office_phone')
                                                            ->label('Office Phone')
                                                            ->tel()
                                                            ->maxLength(20)
                                                            ->prefixIcon('heroicon-o-phone')
                                                            ->columnSpan(1),

                                                        Select::make('education_qualification')
                                                            ->label('Education Qualification')
                                                            ->required()
                                                            ->options(MemberProfile::getEducationQualificationOptions())
                                                            ->prefixIcon('heroicon-o-academic-cap')
                                                            ->columnSpan(1),
                                                    ]),
                                            ])
                                            ->columnSpan(1),

                                        // Work Location
                                        Section::make('Work Location')
                                            ->icon('heroicon-o-map-pin')
                                            ->description('Office address and location details')
                                            ->schema([
                                                Textarea::make('working_place_address')
                                                    ->label('Office Address')
                                                    ->required()
                                                    ->maxLength(500)
                                                    ->rows(4)
                                                    ->placeholder('Building, Floor, Office, Street Address...')
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
                                                TextInput::make('mobile_number')
                                                    ->label('Mobile Number')
                                                    ->required()
                                                    ->tel()
                                                    ->maxLength(20)
                                                    ->prefixIcon('heroicon-o-device-phone-mobile')
                                                    ->columnSpan(1),

                                                TextInput::make('home_phone')
                                                    ->label('Home Phone')
                                                    ->tel()
                                                    ->maxLength(20)
                                                    ->prefixIcon('heroicon-o-phone')
                                                    ->columnSpan(1),
                                            ]),

                                        Textarea::make('permanent_address')
                                            ->label('Permanent Address')
                                            ->required()
                                            ->maxLength(500)
                                            ->rows(4)
                                            ->placeholder('Complete home address...')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Documents & Files')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Document Management')
                                    ->icon('heroicon-o-folder')
                                    ->description('Upload additional documents and certificates')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('additional_files')
                                            ->label('Additional Documents')
                                            ->collection('additional_files')
                                            ->multiple()
                                            ->maxSize(10240) // 10MB
                                            ->acceptedFileTypes([
                                                'application/pdf',
                                                'application/msword',
                                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                                'application/vnd.ms-excel',
                                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                                'image/jpeg',
                                                'image/png',
                                                'image/webp',
                                                'text/plain',
                                            ])
                                            ->helperText('Upload certificates, ID copies, contracts, or other relevant documents (Max: 10MB per file)')
                                            ->downloadable()
                                            ->previewable()
                                            ->reorderable()
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Section::make('Profile Status')
                                    ->icon('heroicon-o-shield-check')
                                    ->description('Manage profile availability and status')
                                    ->schema([
                                        Toggle::make('profile_status')
                                            ->label('Active Profile')
                                            ->default(true)
                                            ->helperText('Enable this to make the profile active and visible in the system')
                                            ->inline(false),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
