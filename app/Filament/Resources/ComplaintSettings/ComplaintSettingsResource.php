<?php

namespace App\Filament\Resources\ComplaintSettings;

use App\Filament\Resources\ComplaintSettings\Pages\CreateComplaintSettings;
use App\Filament\Resources\ComplaintSettings\Pages\EditComplaintSettings;
use App\Filament\Resources\ComplaintSettings\Pages\ListComplaintSettings;
use App\Filament\Resources\ComplaintSettings\Schemas\ComplaintSettingsForm;
use App\Filament\Resources\ComplaintSettings\Tables\ComplaintSettingsTable;
use App\Models\ComplaintSettings;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ComplaintSettingsResource extends Resource
{
    protected static ?string $model = ComplaintSettings::class;

    protected static string|UnitEnum|null $navigationGroup = 'Complaint Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Complaint Settings';

    protected static ?string $modelLabel = 'Complaint Settings';

    protected static ?string $pluralModelLabel = 'Complaint Settings';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return ComplaintSettingsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComplaintSettingsTable::configure($table);
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
            'index' => ListComplaintSettings::route('/'),
            'create' => CreateComplaintSettings::route('/create'),
            'edit' => EditComplaintSettings::route('/{record}/edit'),
        ];
    }
}
