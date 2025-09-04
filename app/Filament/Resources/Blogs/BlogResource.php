<?php

namespace App\Filament\Resources\Blogs;

use App\Filament\Resources\Blogs\Pages\CreateBlog;
use App\Filament\Resources\Blogs\Pages\EditBlog;
use App\Filament\Resources\Blogs\Pages\ListBlogs;
use App\Filament\Resources\Blogs\Schemas\BlogForm;
use App\Filament\Resources\Blogs\Tables\BlogsTable;
use App\Models\Blog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Hexters\HexaLite\HasHexaLite;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use UnitEnum;

class BlogResource extends Resource
{
    use HasHexaLite, Translatable;

    protected static ?string $model = Blog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Blog Management';

    protected static ?int $navigationSort = 1;

    public function defineGates(): array
    {
        return [
            'blog.index' => __('Allows viewing the blog list'),
            'blog.create' => __('Allows creating a new blog'),
            'blog.update' => __('Allows updating blogs'),
            'blog.delete' => __('Allows deleting blogs'),
            'blog.restore' => __('Allows restoring deleted blogs'),
            'blog.replicate' => __('Allows replicating blogs'),
            'blog.reorder' => __('Allows reordering blogs'),
            'blog.force_delete' => __('Allows permanently deleting blogs'),
        ];
    }

    public static function canAccess(): bool
    {
        return hexa()->can('blog.index');
    }

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    public static function form(Schema $schema): Schema
    {
        return BlogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogsTable::configure($table);
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
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }
}
