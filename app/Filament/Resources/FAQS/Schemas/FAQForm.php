<?php

namespace App\Filament\Resources\FAQS\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FAQForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('FAQ Management')
                    ->tabs([
                        Tab::make('Content')
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('question')
                                            ->label('Question')
                                            ->required()
                                            ->maxLength(500)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                                if ($operation === 'create' && $state) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            })
                                            ->placeholder('What question are users frequently asking?')
                                            ->helperText('Enter the question as users would ask it')
                                            ->columnSpanFull(),

                                        Hidden::make('slug')
                                            ->default(fn () => Str::random(10)),
                                    ]),

                                RichEditor::make('answer')
                                    ->label('Answer')
                                    ->required()
                                    ->placeholder('Provide a clear, comprehensive answer...')
                                    ->helperText('Use formatting to make the answer easy to read. Include links, lists, and examples where helpful.')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',
                                        'blockquote',
                                        'codeBlock',
                                        'undo',
                                        'redo',
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Organization')
                            ->icon('heroicon-o-squares-2x2')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('faq_category_id')
                                            ->label('Category')
                                            ->options(function () {
                                                return \App\Models\FAQCategory::active()
                                                    ->ordered()
                                                    ->get()
                                                    ->mapWithKeys(function ($category) {
                                                        $name = $category->getTranslation('name', app()->getLocale())
                                                            ?: $category->getTranslation('name', 'en');

                                                        return [$category->id => $name];
                                                    });
                                            })
                                            ->required()
                                            ->searchable()
                                            ->placeholder('Select a category')
                                            ->helperText('Choose the most relevant category for this FAQ')
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->label('Category Name')
                                                    ->required(),
                                                Textarea::make('description')
                                                    ->label('Description'),
                                                TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(),
                                            ]),

                                        Select::make('category')
                                            ->label('Legacy Category (Deprecated)')
                                            ->options([
                                                'general' => 'General Information',
                                                'account' => 'Account Management',
                                                'events' => 'Events & Registration',
                                                'registration' => 'Registration Process',
                                                'payment' => 'Payment & Billing',
                                                'technical' => 'Technical Support',
                                                'billing' => 'Billing & Invoices',
                                                'support' => 'Customer Support',
                                            ])
                                            ->searchable()
                                            ->placeholder('Select a legacy category (if needed)')
                                            ->helperText('Kept for backward compatibility')
                                            ->dehydrated(false)
                                            ->visible(fn () => app()->environment('local')),

                                        TextInput::make('sort_order')
                                            ->label('Display Order')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0)
                                            ->maxValue(999)
                                            ->placeholder('0')
                                            ->helperText('Lower numbers appear first (0 = highest priority)'),
                                    ]),

                            ]),

                        Tab::make('Visibility')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('status')
                                            ->label('Status')
                                            ->options([
                                                'active' => 'Active',
                                                'inactive' => 'Inactive',
                                            ])
                                            ->default('active')
                                            ->required()
                                            ->helperText('Only active FAQs are visible to users'),

                                        Toggle::make('is_featured')
                                            ->label('Featured FAQ')
                                            ->default(false)
                                            ->helperText('Featured FAQs appear prominently on the FAQ page'),
                                    ]),

                                DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->default(now())
                                    ->seconds(false)
                                    ->native(false)
                                    ->helperText('Schedule when this FAQ becomes visible to users')
                                    ->columnSpanFull(),

                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(60)
                                    ->placeholder('SEO title for search engines')
                                    ->helperText('Recommended: 50-60 characters. Leave empty to auto-generate from question.')
                                    ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                        if (! $state && $get('question')) {
                                            $set('meta_title', Str::limit($get('question').' - FAQ', 60));
                                        }
                                    })
                                    ->columnSpanFull(),

                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->maxLength(160)
                                    ->rows(3)
                                    ->placeholder('Brief description for search engine results')
                                    ->helperText('Recommended: 150-160 characters. Leave empty to auto-generate from answer.')
                                    ->afterStateUpdated(function (callable $get, callable $set, $state) {
                                        if (! $state && $get('answer')) {
                                            $set('meta_description', Str::limit(strip_tags($get('answer')), 160));
                                        }
                                    })
                                    ->columnSpanFull(),

                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
