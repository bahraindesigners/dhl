<?php

namespace App\Filament\Resources\HomeSliders;

use App\Filament\Resources\HomeSliders\Pages\CreateHomeSlider;
use App\Filament\Resources\HomeSliders\Pages\EditHomeSlider;
use App\Filament\Resources\HomeSliders\Pages\ListHomeSliders;
use App\Filament\Resources\HomeSliders\Schemas\HomeSliderForm;
use App\Filament\Resources\HomeSliders\Tables\HomeSlidersTable;
use App\Models\HomeSlider;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class HomeSliderResource extends Resource
{
    use Translatable;

    protected static ?string $model = HomeSlider::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $pluralModelLabel = 'Home Sliders';

    protected static ?string $modelLabel = 'Home Slider';

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    public static function form(Schema $schema): Schema
    {
        return HomeSliderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HomeSlidersTable::configure($table);
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
            'index' => ListHomeSliders::route('/'),
            'create' => CreateHomeSlider::route('/create'),
            'edit' => EditHomeSlider::route('/{record}/edit'),
        ];
    }
}
