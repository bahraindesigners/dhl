<?php

namespace App\Filament\Resources\FAQS;

use App\Filament\Resources\FAQS\Pages\CreateFAQ;
use App\Filament\Resources\FAQS\Pages\EditFAQ;
use App\Filament\Resources\FAQS\Pages\ListFAQS;
use App\Filament\Resources\FAQS\Pages\ViewFAQ;
use App\Filament\Resources\FAQS\Schemas\FAQForm;
use App\Filament\Resources\FAQS\Tables\FAQSTable;
use App\Models\FAQ;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class FAQResource extends Resource
{
    use Translatable;

    protected static ?string $model = FAQ::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $recordTitleAttribute = 'question';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $pluralModelLabel = 'FAQs';

    protected static ?string $modelLabel = 'FAQ';

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    public static function form(Schema $schema): Schema
    {
        return FAQForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FAQSTable::configure($table);
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
            'index' => ListFAQS::route('/'),
            'create' => CreateFAQ::route('/create'),
            // 'view' => ViewFAQ::route('/{record}'),
            'edit' => EditFAQ::route('/{record}/edit'),
        ];
    }
}
