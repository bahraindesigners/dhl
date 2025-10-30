<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Complaint Details')
                    ->tabs([
                        Tab::make('Complaint Information')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Section::make('Complaint Details')
                                            ->icon('heroicon-o-exclamation-triangle')
                                            ->description('Complaint information')
                                            ->schema([
                                                TextEntry::make('ticket_id')
                                                    ->label('Ticket ID')
                                                    ->icon('heroicon-o-ticket')
                                                    ->color('primary')
                                                    ->copyable(),

                                                TextEntry::make('subject')
                                                    ->label('Subject')
                                                    ->icon('heroicon-o-document-text')
                                                    ->color('info'),

                                                TextEntry::make('status')
                                                    ->label('Status')
                                                    ->badge()
                                                    ->icon('heroicon-o-flag')
                                                    ->color(fn($state): string => match ($state) {
                                                        'pending' => 'warning',
                                                        'in_progress' => 'info',
                                                        'resolved' => 'success',
                                                        'closed' => 'gray',
                                                        default => 'gray',
                                                    }),

                                                TextEntry::make('priority')
                                                    ->label('Priority')
                                                    ->badge()
                                                    ->icon('heroicon-o-exclamation-circle')
                                                    ->color(fn($state): string => match ($state) {
                                                        'low' => 'gray',
                                                        'medium' => 'info',
                                                        'high' => 'warning',
                                                        'urgent' => 'danger',
                                                        default => 'gray',
                                                    }),
                                            ])
                                            ->columnSpan(2),

                                        Section::make('Important Dates')
                                            ->icon('heroicon-o-clock')
                                            ->description('Timeline')
                                            ->schema([
                                                TextEntry::make('created_at')
                                                    ->label('Submitted On')
                                                    ->dateTime('M d, Y H:i')
                                                    ->icon('heroicon-o-calendar')
                                                    ->color('gray'),

                                                TextEntry::make('resolved_at')
                                                    ->label('Resolved At')
                                                    ->dateTime('M d, Y H:i')
                                                    ->placeholder('Not yet resolved')
                                                    ->icon('heroicon-o-check-circle')
                                                    ->color('success'),

                                                TextEntry::make('updated_at')
                                                    ->label('Last Updated')
                                                    ->dateTime('M d, Y H:i')
                                                    ->icon('heroicon-o-clock')
                                                    ->color('gray'),
                                            ])
                                            ->columnSpan(1),
                                    ]),

                                Section::make('Complaint Description')
                                    ->icon('heroicon-o-document-text')
                                    ->description('Full complaint details')
                                    ->schema([
                                        TextEntry::make('description')
                                            ->label('Description')
                                            ->placeholder('No description provided')
                                            ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                            ->columnSpanFull()
                                            ->html(),
                                    ])
                                    ->collapsible()
                                    ->collapsed(false),

                                Section::make('Response')
                                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                                    ->description('Admin response and notes')
                                    ->schema([
                                        TextEntry::make('admin_notes')
                                            ->label('Admin Notes')
                                            ->placeholder('No admin notes yet')
                                            ->icon('heroicon-o-document')
                                            ->color('warning')
                                            ->columnSpanFull()
                                            ->html(),
                                    ])
                                    ->collapsible()
                                    ->collapsed(fn($record) => empty($record->admin_notes)),
                            ]),

                        Tab::make('Member Information')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Section::make('User Account')
                                            ->icon('heroicon-o-user-circle')
                                            ->description('Account holder information')
                                            ->schema([
                                                TextEntry::make('user.name')
                                                    ->label('Full Name')
                                                    ->icon('heroicon-o-user')
                                                    ->color('primary'),

                                                TextEntry::make('user.email')
                                                    ->label('Email Address')
                                                    ->icon('heroicon-o-envelope')
                                                    ->color('info')
                                                    ->copyable(),

                                                TextEntry::make('user.created_at')
                                                    ->label('Member Since')
                                                    ->date('M d, Y')
                                                    ->icon('heroicon-o-calendar')
                                                    ->color('gray'),
                                            ])
                                            ->columnSpan(1),

                                        Section::make('Employment Information')
                                            ->icon('heroicon-o-briefcase')
                                            ->description('Work details and position')
                                            ->schema([
                                                TextEntry::make('memberProfile.staff_number')
                                                    ->label('Staff Number')
                                                    ->formatStateUsing(fn($state) => 'EMP-' . $state)
                                                    ->icon('heroicon-o-identification')
                                                    ->color('info')
                                                    ->copyable(),

                                                TextEntry::make('memberProfile.position')
                                                    ->label('Position')
                                                    ->icon('heroicon-o-user-circle')
                                                    ->color('primary'),

                                                TextEntry::make('memberProfile.department')
                                                    ->label('Department')
                                                    ->icon('heroicon-o-building-office')
                                                    ->color('success'),

                                                TextEntry::make('memberProfile.section')
                                                    ->label('Section')
                                                    ->placeholder('Not specified')
                                                    ->icon('heroicon-o-squares-2x2')
                                                    ->color('gray'),

                                                TextEntry::make('memberProfile.date_of_joining')
                                                    ->label('Date of Joining')
                                                    ->date('M d, Y')
                                                    ->icon('heroicon-o-calendar-days')
                                                    ->color('info'),
                                            ])
                                            ->columnSpan(1),

                                        Section::make('Personal Details')
                                            ->icon('heroicon-o-identification')
                                            ->description('Personal information')
                                            ->schema([
                                                TextEntry::make('memberProfile.cpr_number')
                                                    ->label('CPR Number')
                                                    ->icon('heroicon-o-identification')
                                                    ->color('warning')
                                                    ->copyable(),

                                                TextEntry::make('memberProfile.nationality')
                                                    ->label('Nationality')
                                                    ->icon('heroicon-o-flag')
                                                    ->color('info'),

                                                TextEntry::make('memberProfile.gender')
                                                    ->label('Gender')
                                                    ->formatStateUsing(fn($state) => ucfirst($state))
                                                    ->icon('heroicon-o-user')
                                                    ->color('gray'),

                                                TextEntry::make('memberProfile.marital_status')
                                                    ->label('Marital Status')
                                                    ->formatStateUsing(fn($state) => ucfirst(str_replace('_', ' ', $state)))
                                                    ->icon('heroicon-o-heart')
                                                    ->color('purple'),
                                            ])
                                            ->columnSpan(1),
                                    ]),

                                Section::make('Contact Information')
                                    ->icon('heroicon-o-phone')
                                    ->description('Contact details and addresses')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('memberProfile.mobile_number')
                                                    ->label('Mobile Number')
                                                    ->icon('heroicon-o-device-phone-mobile')
                                                    ->color('success')
                                                    ->copyable(),

                                                TextEntry::make('memberProfile.office_phone')
                                                    ->label('Office Phone')
                                                    ->placeholder('Not provided')
                                                    ->icon('heroicon-o-phone')
                                                    ->color('info')
                                                    ->copyable(),

                                                TextEntry::make('memberProfile.home_phone')
                                                    ->label('Home Phone')
                                                    ->placeholder('Not provided')
                                                    ->icon('heroicon-o-phone')
                                                    ->color('gray')
                                                    ->copyable(),

                                                TextEntry::make('memberProfile.education_qualification')
                                                    ->label('Education Qualification')
                                                    ->icon('heroicon-o-academic-cap')
                                                    ->color('purple'),
                                            ]),

                                        TextEntry::make('memberProfile.working_place_address')
                                            ->label('Work Address')
                                            ->icon('heroicon-o-building-office-2')
                                            ->color('info')
                                            ->columnSpanFull(),

                                        TextEntry::make('memberProfile.permanent_address')
                                            ->label('Permanent Address')
                                            ->icon('heroicon-o-home')
                                            ->color('gray')
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
