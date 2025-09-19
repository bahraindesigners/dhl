import { useTranslation } from 'react-i18next';
import { Search, Filter, X } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { DownloadCategory } from '@/types';

interface ResourceFiltersProps {
    categories: DownloadCategory[];
    filters: {
        search: string;
        category: string;
        accessLevel: string;
        fileType: string;
        sortBy: string;
    };
    onFiltersChange: (filters: any) => void;
    totalResults: number;
}

export const ResourceFilters = ({ categories, filters, onFiltersChange, totalResults }: ResourceFiltersProps) => {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    const handleFilterChange = (key: string, value: string) => {
        onFiltersChange({
            ...filters,
            [key]: value
        });
    };

    const clearAllFilters = () => {
        onFiltersChange({
            search: '',
            category: '',
            accessLevel: '',
            fileType: '',
            sortBy: 'newest'
        });
    };

    const hasActiveFilters = filters.search || filters.category || filters.accessLevel || filters.fileType;

    const fileTypeOptions = [
        { value: '', label: t('resources.allFileTypes') || 'All File Types' },
        { value: 'pdf', label: 'PDF' },
        { value: 'doc', label: 'Document (DOC/DOCX)' },
        { value: 'image', label: 'Image' },
        { value: 'video', label: 'Video' },
        { value: 'audio', label: 'Audio' },
        { value: 'spreadsheet', label: 'Spreadsheet (XLS/XLSX)' },
        { value: 'archive', label: 'Archive (ZIP/RAR)' },
        { value: 'code', label: 'Code (JS/TS/JSON)' }
    ];

    const accessLevelOptions = [
        { value: '', label: t('resources.allAccess') || 'All Access Levels' },
        { value: 'public', label: t('resources.publicAccess') || 'Public' },
        { value: 'members', label: t('resources.membersOnly') || 'Members Only' }
    ];

    const sortOptions = [
        { value: 'newest', label: t('resources.sortNewest') || 'Newest First' },
        { value: 'oldest', label: t('resources.sortOldest') || 'Oldest First' },
        { value: 'alphabetical', label: t('resources.sortAlphabetical') || 'Alphabetical' },
        { value: 'downloads', label: t('resources.sortMostDownloads') || 'Most Downloads' }
    ];

    return (
        <div className="bg-card border rounded-lg p-6 mb-6">
            {/* Search Bar */}
            <div className="mb-6">
                <div className="relative">
                    <Search className={`absolute top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground ${isRTL ? 'right-3' : 'left-3'}`} />
                    <Input
                        type="text"
                        placeholder={t('resources.searchPlaceholder') || 'Search resources...'}
                        value={filters.search}
                        onChange={(e) => handleFilterChange('search', e.target.value)}
                        className={`${isRTL ? 'pr-10 font-arabic text-right' : 'pl-10'}`}
                    />
                </div>
            </div>

            {/* Filter Controls */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                {/* Category Filter */}
                <div>
                    <label className={`block text-sm font-medium text-foreground mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('resources.category') || 'Category'}
                    </label>
                    <select
                        value={filters.category}
                        onChange={(e) => handleFilterChange('category', e.target.value)}
                        className={`w-full px-3 py-2 border border-input bg-background rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent ${isRTL ? 'font-arabic text-right' : ''}`}
                    >
                        <option value="">{t('resources.allCategories') || 'All Categories'}</option>
                        {categories.map((category) => (
                            <option key={category.id} value={category.id.toString()}>
                                {typeof category.name === 'object' 
                                    ? category.name[i18n.language] || category.name['en'] || Object.values(category.name)[0]
                                    : category.name
                                }
                            </option>
                        ))}
                    </select>
                </div>

                {/* Access Level Filter */}
                <div>
                    <label className={`block text-sm font-medium text-foreground mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('resources.accessLevel') || 'Access Level'}
                    </label>
                    <select
                        value={filters.accessLevel}
                        onChange={(e) => handleFilterChange('accessLevel', e.target.value)}
                        className={`w-full px-3 py-2 border border-input bg-background rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent ${isRTL ? 'font-arabic text-right' : ''}`}
                    >
                        {accessLevelOptions.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                </div>

                {/* File Type Filter */}
                <div>
                    <label className={`block text-sm font-medium text-foreground mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('resources.fileType') || 'File Type'}
                    </label>
                    <select
                        value={filters.fileType}
                        onChange={(e) => handleFilterChange('fileType', e.target.value)}
                        className={`w-full px-3 py-2 border border-input bg-background rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent ${isRTL ? 'font-arabic text-right' : ''}`}
                    >
                        {fileTypeOptions.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                </div>

                {/* Sort By */}
                <div>
                    <label className={`block text-sm font-medium text-foreground mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('resources.sortBy') || 'Sort by'}
                    </label>
                    <select
                        value={filters.sortBy}
                        onChange={(e) => handleFilterChange('sortBy', e.target.value)}
                        className={`w-full px-3 py-2 border border-input bg-background rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent ${isRTL ? 'font-arabic text-right' : ''}`}
                    >
                        {sortOptions.map((option) => (
                            <option key={option.value} value={option.value}>
                                {option.label}
                            </option>
                        ))}
                    </select>
                </div>
            </div>

            {/* Results Count and Clear Filters */}
            <div className={`flex items-center justify-between ${isRTL ? 'flex-row-reverse' : ''}`}>
                <span className={`text-sm text-muted-foreground ${isRTL ? 'font-arabic' : ''}`}>
                    {t('resources.resultsCount', { count: totalResults }) || `${totalResults} Results`}
                </span>
                
                {hasActiveFilters && (
                    <Button
                        variant="outline"
                        size="sm"
                        onClick={clearAllFilters}
                        className={`${isRTL ? 'font-arabic' : ''}`}
                    >
                        <X className={`h-4 w-4 ${isRTL ? 'ml-2' : 'mr-2'}`} />
                        {t('resources.clearFilters') || 'Clear Filters'}
                    </Button>
                )}
            </div>
        </div>
    );
};