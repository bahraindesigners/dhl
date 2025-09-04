<?php

namespace App\Filament\Resources\EventRegistrations\Schemas;

use App\Models\Event;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class EventRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Registration Details')
                    ->tabs([
                        Tab::make('Basic Information')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Event & User')
                                    ->description('Select the event and associate with a user if needed')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('event_id')
                                                    ->label('Event')
                                                    ->relationship('event', 'title')
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, $set) {
                                                        if ($state) {
                                                            $event = Event::find($state);
                                                            if ($event) {
                                                                $set('amount_paid', $event->price ?? 0);
                                                            }
                                                        }
                                                    })
                                                    ->columnSpan(1),

                                                Select::make('user_id')
                                                    ->label('Associated User (Optional)')
                                                    ->relationship('user', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, $set) {
                                                        if ($state) {
                                                            $user = \App\Models\User::find($state);
                                                            if ($user) {
                                                                $set('first_name', $user->first_name ?? explode(' ', $user->name)[0] ?? '');
                                                                $set('last_name', $user->last_name ?? explode(' ', $user->name)[1] ?? '');
                                                                $set('email', $user->email);
                                                            }
                                                        }
                                                    })
                                                    ->columnSpan(1),
                                            ]),
                                    ]),

                                Section::make('Registrant Information')
                                    ->description('Personal details of the person registering for the event')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('first_name')
                                                    ->label('First Name')
                                                    ->required()
                                                    ->maxLength(255),

                                                TextInput::make('last_name')
                                                    ->label('Last Name')
                                                    ->required()
                                                    ->maxLength(255),

                                                TextInput::make('email')
                                                    ->label('Email Address')
                                                    ->email()
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(ignoreRecord: true)
                                                    ->columnSpan(1),

                                                TextInput::make('phone')
                                                    ->label('Phone Number')
                                                    ->tel()
                                                    ->maxLength(20)
                                                    ->columnSpan(1),
                                            ]),

                                        Textarea::make('special_requirements')
                                            ->label('Special Requirements')
                                            ->placeholder('Any dietary restrictions, accessibility needs, or other special requirements...')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Registration Status')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                Section::make('Status Management')
                                    ->description('Manage the registration status and important dates')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('status')
                                                    ->label('Registration Status')
                                                    ->options([
                                                        'pending' => 'Pending',
                                                        'confirmed' => 'Confirmed',
                                                        'cancelled' => 'Cancelled',
                                                        'attended' => 'Attended',
                                                    ])
                                                    ->required()
                                                    ->default('pending')
                                                    ->live()
                                                    ->native(false),

                                                DateTimePicker::make('registered_at')
                                                    ->label('Registration Date')
                                                    ->required()
                                                    ->default(now())
                                                    ->seconds(false)
                                                    ->native(false),

                                                DateTimePicker::make('confirmed_at')
                                                    ->label('Confirmation Date')
                                                    ->seconds(false)
                                                    ->native(false)
                                                    ->visible(fn ($get) => in_array($get('status'), ['confirmed', 'attended'])),

                                                DateTimePicker::make('cancelled_at')
                                                    ->label('Cancellation Date')
                                                    ->seconds(false)
                                                    ->native(false)
                                                    ->visible(fn ($get) => $get('status') === 'cancelled'),
                                            ]),
                                    ]),

                                Section::make('Additional Information')
                                    ->schema([
                                        Textarea::make('admin_notes')
                                            ->label('Admin Notes')
                                            ->placeholder('Internal notes about this registration...')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Payment Information')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Section::make('Payment Details')
                                    ->description('Track payment information for paid events')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('amount_paid')
                                                    ->label('Amount Paid')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->default(0)
                                                    ->step(0.01)
                                                    ->required(),

                                                Select::make('payment_status')
                                                    ->label('Payment Status')
                                                    ->options([
                                                        'pending' => 'Pending',
                                                        'paid' => 'Paid',
                                                        'refunded' => 'Refunded',
                                                        'failed' => 'Failed',
                                                    ])
                                                    ->required()
                                                    ->default('pending')
                                                    ->native(false),

                                                Select::make('payment_method')
                                                    ->label('Payment Method')
                                                    ->options([
                                                        'cash' => 'Cash',
                                                        'online' => 'Online Payment',
                                                        'bank_transfer' => 'Bank Transfer',
                                                        'cheque' => 'Cheque',
                                                        'other' => 'Other',
                                                    ])
                                                    ->native(false),

                                                TextInput::make('payment_reference')
                                                    ->label('Payment Reference')
                                                    ->placeholder('Transaction ID, receipt number, etc.')
                                                    ->maxLength(255),
                                            ]),
                                    ]),
                            ]),

                        // Tab::make('Custom Data')
                        //     ->icon('heroicon-o-document-text')
                        //     ->schema([
                        //         Section::make('Additional Registration Data')
                        //             ->description('Store custom form data or additional information')
                        //             ->schema([
                        //                 Textarea::make('registration_data')
                        //                     ->label('Custom Registration Data (JSON)')
                        //                     ->placeholder('{"custom_field": "value", "additional_info": "data"}')
                        //                     ->rows(6)
                        //                     ->columnSpanFull()
                        //                     ->helperText('Store additional form data as JSON. This field is useful for custom registration forms.'),
                        //             ]),
                        //     ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
