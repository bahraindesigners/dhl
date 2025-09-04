<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Hexters\HexaLite\HasHexaLite;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class EventResource extends Resource
{
    use Translatable, HasHexaLite;

    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 2;

    public function defineGates(): array
    {
        return [
            'event.index' => __('Allows viewing the event list'),
            'event.create' => __('Allows creating a new event'),
            'event.update' => __('Allows updating events'),
            'event.delete' => __('Allows deleting events'),
            'event.restore' => __('Allows restoring deleted events'),
            'event.replicate' => __('Allows replicating events'),
            'event.reorder' => __('Allows reordering events'),
            'event.force_delete' => __('Allows permanently deleting events'),
        ];
    }

    public static function canAccess(): bool
    {
        return hexa()->can('event.index');
    }

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
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
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
