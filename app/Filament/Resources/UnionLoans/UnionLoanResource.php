<?php

namespace App\Filament\Resources\UnionLoans;

use App\Filament\Resources\UnionLoans\Pages\CreateUnionLoan;
use App\Filament\Resources\UnionLoans\Pages\EditUnionLoan;
use App\Filament\Resources\UnionLoans\Pages\ListUnionLoans;
use App\Filament\Resources\UnionLoans\Pages\ViewUnionLoan;
use App\Filament\Resources\UnionLoans\Schemas\UnionLoanForm;
use App\Filament\Resources\UnionLoans\Schemas\UnionLoanInfolist;
use App\Filament\Resources\UnionLoans\Tables\UnionLoansTable;
use App\Models\UnionLoan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UnionLoanResource extends Resource
{
    protected static ?string $model = UnionLoan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Loan Applications';

    protected static ?string $modelLabel = 'Loan Application';

    protected static ?string $pluralModelLabel = 'Loan Applications';

    protected static string|UnitEnum|null $navigationGroup = 'Union Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'amount';

    public static function form(Schema $schema): Schema
    {
        return UnionLoanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UnionLoanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnionLoansTable::configure($table);
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
            'index' => ListUnionLoans::route('/'),
            'create' => CreateUnionLoan::route('/create'),
            'view' => ViewUnionLoan::route('/{record}'),
            'edit' => EditUnionLoan::route('/{record}/edit'),
        ];
    }
}
