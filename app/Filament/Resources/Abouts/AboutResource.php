<?php

namespace App\Filament\Resources\Abouts;

use App\Filament\Resources\Abouts\Pages\EditAbout;
use App\Filament\Resources\Abouts\Pages\ListAbouts;
use App\Filament\Resources\Abouts\Schemas\AboutForm;
use App\Filament\Resources\Abouts\Schemas\AboutInfolist;
use App\Filament\Resources\Abouts\Tables\AboutsTable;
use App\Models\About;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class AboutResource extends Resource
{
    use Translatable;
    protected static ?string $model = About::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static string|UnitEnum|null $navigationGroup = 'About Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationLabel(): string
    {
        return 'About Page';
    }

    public static function getModelLabel(): string
    {
        return 'About Page';
    }

    public static function getPluralModelLabel(): string
    {
        return 'About Page';
    }

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    public static function getTranslatableAttributes(): array
    {
        return ['title', 'content', 'board_section_title', 'board_section_description'];
    }

    public static function form(Schema $schema): Schema
    {
        return AboutForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AboutInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutsTable::configure($table);
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
            'index' => ListAbouts::route('/'),
            'edit' => EditAbout::route('/{record}/edit'),
        ];
    }
}
