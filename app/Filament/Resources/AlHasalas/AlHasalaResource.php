<?php

namespace App\Filament\Resources\AlHasalas;

use App\Filament\Resources\AlHasalas\Pages\CreateAlHasala;
use App\Filament\Resources\AlHasalas\Pages\EditAlHasala;
use App\Filament\Resources\AlHasalas\Pages\ListAlHasalas;
use App\Filament\Resources\AlHasalas\Pages\ViewAlHasala;
use App\Filament\Resources\AlHasalas\Schemas\AlHasalaForm;
use App\Filament\Resources\AlHasalas\Schemas\AlHasalaInfolist;
use App\Filament\Resources\AlHasalas\Tables\AlHasalasTable;
use App\Models\AlHasala;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AlHasalaResource extends Resource
{
    protected static ?string $model = AlHasala::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Al Hasala Applications';

    protected static ?string $modelLabel = 'Al Hasala Application';

    protected static ?string $pluralModelLabel = 'Al Hasala Applications';

    protected static string|UnitEnum|null $navigationGroup = 'Union Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'monthly_amount';

    public static function form(Schema $schema): Schema
    {
        return AlHasalaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AlHasalaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlHasalasTable::configure($table);
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
            'index' => ListAlHasalas::route('/'),
            'create' => CreateAlHasala::route('/create'),
            'view' => ViewAlHasala::route('/{record}'),
            'edit' => EditAlHasala::route('/{record}/edit'),
        ];
    }
}
