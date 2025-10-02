<?php

namespace App\Filament\Resources\MembershipPages;

use App\Filament\Resources\MembershipPages\Pages\EditMembershipPage;
use App\Filament\Resources\MembershipPages\Pages\ManageMembershipPages;
use App\Filament\Resources\MembershipPages\Schemas\MembershipPageForm;
use App\Models\MembershipPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class MembershipPageResource extends Resource
{
    use Translatable;

    protected static ?string $model = MembershipPage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Member Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Membership Page';

    protected static ?string $modelLabel = 'Membership Page';

    protected static ?string $pluralModelLabel = 'Membership Page';

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    public static function getTranslatableAttributes(): array
    {
        return ['how_to_join', 'union_benefits'];
    }

    public static function form(Schema $schema): Schema
    {
        return MembershipPageForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMembershipPages::route('/'),
            'edit' => EditMembershipPage::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationUrl(array $parameters = []): string
    {
        $record = MembershipPage::getSingleton();

        return static::getUrl('edit', ['record' => $record->id]);
    }
}
