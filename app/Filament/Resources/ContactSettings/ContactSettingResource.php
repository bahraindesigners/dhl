<?php

namespace App\Filament\Resources\ContactSettings;

use App\Filament\Resources\ContactSettings\Pages\EditContactSetting;
use App\Filament\Resources\ContactSettings\Pages\ManageContactSettings;
use App\Filament\Resources\ContactSettings\Schemas\ContactSettingForm;
use App\Models\ContactSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class ContactSettingResource extends Resource
{
    use Translatable;

    protected static ?string $model = ContactSetting::class;

    protected static string|UnitEnum|null $navigationGroup = 'Contact Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Contact Settings';

    protected static ?string $modelLabel = 'Contact Settings';

    protected static ?string $pluralModelLabel = 'Contact Settings';

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    public static function getTranslatableAttributes(): array
    {
        return ['office_address', 'phone_numbers', 'office_hours', 'content'];
    }

    public static function form(Schema $schema): Schema
    {
        return ContactSettingForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageContactSettings::route('/'),
            'edit' => EditContactSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationUrl(array $parameters = []): string
    {
        $record = ContactSetting::getSingleton();

        return static::getUrl('edit', ['record' => $record->id]);
    }
}
