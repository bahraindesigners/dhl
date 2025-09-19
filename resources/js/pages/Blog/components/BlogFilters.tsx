import { useTranslation } from 'react-i18next';
import { Search } from 'lucide-react';
import { BlogCategory } from '@/types';

interface BlogFiltersProps {
    searchTerm: string;
    setSearchTerm: (term: string) => void;
    selectedCategory: string | number;
    setSelectedCategory: (category: string | number) => void;
    selectedSort: string;
    setSelectedSort: (sort: string) => void;
    showFeaturedOnly: boolean;
    setShowFeaturedOnly: (featured: boolean) => void;
    categories: BlogCategory[];
    renderContent: (content: any) => string;
}

export default function BlogFilters({
    searchTerm,
    setSearchTerm,
    selectedCategory,
    setSelectedCategory,
    selectedSort,
    setSelectedSort,
    showFeaturedOnly,
    setShowFeaturedOnly,
    categories,
    renderContent
}: BlogFiltersProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    return (
        <section className={`py-8 bg-white border-b border-gray-200 ${isRTL ? 'rtl' : ''}`}>
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    {/* Search */}
                    <div className="relative flex-1 max-w-md">
                        <div className="absolute inset-y-0 left-0 flex items-center pl-3">
                            <Search className="h-5 w-5 text-gray-400" />
                        </div>
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder={t('blog.searchPlaceholder') || 'Search articles...'}
                            className={`w-full rounded-lg border border-gray-300 py-2 pl-10 pr-4 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary ${isRTL ? 'font-arabic text-right' : ''}`}
                        />
                    </div>

                    {/* Filters */}
                    <div className={`flex flex-wrap gap-4 ${isRTL ? 'flex-row-reverse' : ''}`}>
                        {/* Category Filter */}
                        <select
                            value={selectedCategory}
                            onChange={(e) => setSelectedCategory(e.target.value)}
                            className={`rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary ${isRTL ? 'font-arabic' : ''}`}
                        >
                            <option value="">{t('blog.allCategories') || 'All Categories'}</option>
                            {categories.map((category) => (
                                <option key={category.id} value={category.id}>
                                    {renderContent(category.name)}
                                </option>
                            ))}
                        </select>

                        {/* Sort Filter */}
                        <select
                            value={selectedSort}
                            onChange={(e) => setSelectedSort(e.target.value)}
                            className={`rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary ${isRTL ? 'font-arabic' : ''}`}
                        >
                            <option value="latest">{t('blog.sortLatest') || 'Latest'}</option>
                            <option value="oldest">{t('blog.sortOldest') || 'Oldest'}</option>
                            <option value="popular">{t('blog.sortPopular') || 'Most Popular'}</option>
                            <option value="alphabetical">{t('blog.sortAlphabetical') || 'Alphabetical'}</option>
                        </select>

                        {/* Featured Filter */}
                        <label className={`flex items-center gap-2 text-sm ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}>
                            <input
                                type="checkbox"
                                checked={showFeaturedOnly}
                                onChange={(e) => setShowFeaturedOnly(e.target.checked)}
                                className="rounded border-gray-300 text-primary focus:ring-primary"
                            />
                            <span>{t('blog.featuredOnly') || 'Featured Only'}</span>
                        </label>
                    </div>
                </div>
            </div>
        </section>
    );
}