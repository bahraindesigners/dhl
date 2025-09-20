<?php

namespace App\Filament\Resources\UnionLoanSettings;

use App\Filament\Resources\UnionLoanSettings\Pages\CreateUnionLoanSettings;
use App\Filament\Resources\UnionLoanSettings\Pages\EditUnionLoanSettings;
use App\Filament\Resources\UnionLoanSettings\Pages\ListUnionLoanSettings;
use App\Filament\Resources\UnionLoanSettings\Schemas\UnionLoanSettingsForm;
use App\Filament\Resources\UnionLoanSettings\Tables\UnionLoanSettingsTable;
use App\Models\UnionLoanSettings;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UnionLoanSettingsResource extends Resource
{
    protected static ?string $model = UnionLoanSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Loan Settings';

    protected static ?string $modelLabel = 'Loan Settings';

    protected static ?string $pluralModelLabel = 'Loan Settings';

    protected static string|UnitEnum|null $navigationGroup = 'Union Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'max_months';

    public static function form(Schema $schema): Schema
    {
        return UnionLoanSettingsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnionLoanSettingsTable::configure($table);
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
            'index' => ListUnionLoanSettings::route('/'),
            'create' => CreateUnionLoanSettings::route('/create'),
            'edit' => EditUnionLoanSettings::route('/{record}/edit'),
        ];
    }
}
