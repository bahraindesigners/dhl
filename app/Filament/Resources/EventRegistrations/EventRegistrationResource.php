<?php

namespace App\Filament\Resources\EventRegistrations;

use App\Filament\Resources\EventRegistrations\Pages\CreateEventRegistration;
use App\Filament\Resources\EventRegistrations\Pages\EditEventRegistration;
use App\Filament\Resources\EventRegistrations\Pages\ListEventRegistrations;
use App\Filament\Resources\EventRegistrations\Schemas\EventRegistrationForm;
use App\Filament\Resources\EventRegistrations\Tables\EventRegistrationsTable;
use App\Models\EventRegistration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Hexters\HexaLite\HasHexaLite;
use UnitEnum;

class EventRegistrationResource extends Resource
{
    use HasHexaLite;

    protected static ?string $model = EventRegistration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Registrations';

    public function defineGates(): array
    {
        return [
            'event_registration.index' => __('Allows viewing the event registration list'),
            'event_registration.create' => __('Allows creating a new event registration'),
            'event_registration.update' => __('Allows updating event registrations'),
            'event_registration.delete' => __('Allows deleting event registrations'),
            'event_registration.restore' => __('Allows restoring deleted event registrations'),
            'event_registration.replicate' => __('Allows replicating event registrations'),
            'event_registration.reorder' => __('Allows reordering event registrations'),
            'event_registration.force_delete' => __('Allows permanently deleting event registrations'),
        ];
    }

    public static function canAccess(): bool
    {
        return hexa()->can('event_registration.index');
    }

    public static function form(Schema $schema): Schema
    {
        return EventRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventRegistrationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventRegistrations::route('/'),
            'create' => CreateEventRegistration::route('/create'),
            'edit' => EditEventRegistration::route('/{record}/edit'),
        ];
    }
}
