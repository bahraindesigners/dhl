<?php

namespace App\Filament\Resources\Blogs\Schemas;

use App\Models\BlogCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Blog Content')
                    ->tabs([
                        Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->columnSpanFull(),
                                        
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->columnSpanFull(),
                                        
                                        Textarea::make('excerpt')
                                            ->label('Excerpt')
                                            ->rows(3)
                                            ->helperText('A brief summary of the blog post')
                                            ->columnSpanFull(),
                                    ]),
                                
                                RichEditor::make('content')
                                    ->label('Content')
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('blog-content/attachments')
                                    ->extraAttributes(['style' => 'min-height: 200px;'])
                                    ->helperText('Use the "Attach Files" button in the toolbar to upload images directly into your content')
                                    ->toolbarButtons([
                                        'alignStart',
                                        'alignCenter', 
                                        'alignEnd',
                                        'alignJustify',
                                        'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ]),
                            ]),
                        
                        Tab::make('Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Featured Image')
                                    ->description('Main image displayed with the blog post')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('featured_image')
                                            ->label('Featured Image')
                                            ->collection('featured_image')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                null, // Free cropping
                                                '16:9',
                                                '9:16',
                                                '4:3',
                                                '1:1',
                                                '3:2',
                                                '21:9',
                                            ])
                                            ->imageEditorMode(2)
                                            ->imageResizeMode('contain')
                                            ->imageResizeTargetWidth('2400')
                                            ->imageResizeTargetHeight('1600')
                                            ->helperText('High quality image (95% quality) - click the pencil icon to crop, resize, or edit')
                                            ->columnSpanFull(),
                                    ]),
                                
                                Section::make('Gallery')
                                    ->description('Additional images for the blog post gallery')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->label('Gallery Images')
                                            ->collection('gallery')
                                            ->multiple()
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                null,
                                                '16:9',
                                                '9:16',
                                                '4:3',
                                                '1:1',
                                                '3:2',
                                                '21:9',
                                            ])
                                            ->imageResizeMode('contain')
                                            ->imageResizeTargetWidth('2400')
                                            ->imageResizeTargetHeight('1600')
                                            ->reorderable()
                                            ->helperText('High quality gallery images (95% quality)')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        
                        Tab::make('Settings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Publication')
                                            ->schema([
                                                Select::make('blog_category_id')
                                                    ->label('Category')
                                                    ->options(function () {
                                                        return BlogCategory::active()->get()->pluck(function ($category) {
                                                            return $category->getTranslation('name', 'en') ?: $category->getTranslation('name', 'ar');
                                                        }, 'id');
                                                    })
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                                
                                                Select::make('status')
                                                    ->options([
                                                        'draft' => 'Draft',
                                                        'published' => 'Published',
                                                        'scheduled' => 'Scheduled',
                                                        'archived' => 'Archived',
                                                    ])
                                                    ->default('draft')
                                                    ->required(),
                                                
                                                DateTimePicker::make('published_at')
                                                    ->label('Publish Date')
                                                    ->default(now())
                                                    ->required(),
                                                
                                                Toggle::make('featured')
                                                    ->label('Featured Post')
                                                    ->default(false)
                                                    ->helperText('Featured posts appear prominently on the site'),
                                                
                                                Toggle::make('show_as_urgent_news')
                                                    ->label('Show as Urgent News')
                                                    ->default(false)
                                                    ->helperText('Mark this post as urgent news to highlight it'),
                                            ]),
                                        
                                        Section::make('Metadata')
                                            ->schema([
                                                Hidden::make('author')
                                                    ->default(fn () => Auth::user()?->name ?? 'Admin'),
                                                
                                                TextInput::make('reading_time')
                                                    ->label('Reading Time (minutes)')
                                                    ->numeric()
                                                    ->helperText('Leave empty to auto-calculate')
                                                    ->placeholder('Auto-calculated'),
                                                
                                                TextInput::make('views_count')
                                                    ->label('Views Count')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->disabled()
                                                    ->dehydrated(false),
                                            ]),
                                    ]),
                            ]),
                        
                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(60)
                                            ->helperText('Recommended: 50-60 characters')
                                            ->columnSpanFull(),
                                        
                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Recommended: 150-160 characters')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
