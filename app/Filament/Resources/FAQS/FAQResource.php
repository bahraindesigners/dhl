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
use Hexters\HexaLite\HasHexaLite;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class FAQResource extends Resource
{
    use HasHexaLite, Translatable;

    protected static ?string $model = FAQ::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $recordTitleAttribute = 'question';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $pluralModelLabel = 'FAQs';

    protected static ?string $modelLabel = 'FAQ';

    public function defineGates(): array
    {
        return [
            'faq.index' => __('Allows viewing the FAQ list'),
            'faq.create' => __('Allows creating a new FAQ'),
            'faq.update' => __('Allows updating FAQs'),
            'faq.delete' => __('Allows deleting FAQs'),
            'faq.restore' => __('Allows restoring deleted FAQs'),
            'faq.replicate' => __('Allows replicating FAQs'),
            'faq.reorder' => __('Allows reordering FAQs'),
            'faq.force_delete' => __('Allows permanently deleting FAQs'),
        ];
    }

    public static function canAccess(): bool
    {
        return hexa()->can('faq.index');
    }

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
