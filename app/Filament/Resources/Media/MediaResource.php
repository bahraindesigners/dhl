<?php

namespace App\Filament\Resources\Media;

use App\Filament\Resources\Media\Pages\ListMedia;
use App\Filament\Resources\Media\Tables\MediaTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Hexters\HexaLite\HasHexaLite;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use UnitEnum;

class MediaResource extends Resource
{
    use HasHexaLite;

    protected static ?string $model = Media::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Media Library';

    protected static ?string $modelLabel = 'Media File';

    protected static ?string $pluralModelLabel = 'Media Files';

    public function defineGates(): array
    {
        return [
            'media.index' => __('Allows viewing the media library'),
            'media.create' => __('Allows uploading new media'),
            'media.update' => __('Allows updating media files'),
            'media.delete' => __('Allows deleting media files'),
            'media.restore' => __('Allows restoring deleted media files'),
            'media.replicate' => __('Allows replicating media files'),
            'media.reorder' => __('Allows reordering media files'),
            'media.force_delete' => __('Allows permanently deleting media files'),
        ];
    }

    public static function canAccess(): bool
    {
        return hexa()->can('media.index');
    }

    public static function table(Table $table): Table
    {
        return MediaTable::configure($table);
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
            'index' => ListMedia::route('/'),
            // 'create' => CreateMedia::route('/create'),
            // 'edit' => EditMedia::route('/{record}/edit'),
        ];
    }
}
