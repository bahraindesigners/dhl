<?php

namespace App\Filament\Resources\AlHasalaSettings;

use App\Filament\Resources\AlHasalaSettings\Pages\EditAlHasalaSettings;
use App\Filament\Resources\AlHasalaSettings\Pages\ManageAlHasalaSettings;
use App\Filament\Resources\AlHasalaSettings\Schemas\AlHasalaSettingsForm;
use App\Models\AlHasalaSettings;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AlHasalaSettingsResource extends Resource
{
    protected static ?string $model = AlHasalaSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Al Hasala Settings';

    protected static ?string $modelLabel = 'Al Hasala Settings';

    protected static ?string $pluralModelLabel = 'Al Hasala Settings';

    protected static string|UnitEnum|null $navigationGroup = 'Union Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'max_months';

    public static function form(Schema $schema): Schema
    {
        return AlHasalaSettingsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // Not used for singleton
        return $table;
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
            'index' => ManageAlHasalaSettings::route('/'),
            'edit' => EditAlHasalaSettings::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationUrl(array $parameters = []): string
    {
        $record = AlHasalaSettings::getSingleton();

        return static::getUrl('edit', ['record' => $record->id]);
    }
}
