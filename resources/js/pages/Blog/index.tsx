import NavbarLayout from '@/layouts/navbar-layout';
import { Head, router, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { type SharedData, Blog, BlogCategory } from '@/types';
import { useState, useEffect } from 'react';
import BlogHero from './components/BlogHero';
import BlogFilters from './components/BlogFilters';
import BlogGrid from './components/BlogGrid';
import { renderContent, formatDate } from './utils/contentUtils';

interface BlogIndexProps {
    blogs: {
        data: Blog[];
        links: any[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number;
        to: number;
        first_page_url: string;
        last_page_url: string;
        next_page_url: string | null;
        prev_page_url: string | null;
        path: string;
    };
    categories: BlogCategory[];
    filters: {
        search?: string;
        category?: number;
        featured?: boolean;
        sort?: string;
    };
}

export default function BlogIndex() {
    const { blogs, categories, filters } = usePage<SharedData & BlogIndexProps>().props;
    const { t, i18n } = useTranslation();

    // Local state for filters
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [selectedCategory, setSelectedCategory] = useState(filters.category || '');
    const [selectedSort, setSelectedSort] = useState(filters.sort || 'latest');
    const [showFeaturedOnly, setShowFeaturedOnly] = useState(filters.featured || false);

    // Handle filter changes
    const handleFilterChange = () => {
        const params = new URLSearchParams();
        
        if (searchTerm) params.append('search', searchTerm);
        if (selectedCategory) params.append('category', selectedCategory.toString());
        if (showFeaturedOnly) params.append('featured', '1');
        if (selectedSort !== 'latest') params.append('sort', selectedSort);

        router.get('/news', Object.fromEntries(params), {
            preserveState: true,
            preserveScroll: true,
        });
    };

    // Debounced search
    useEffect(() => {
        const timeout = setTimeout(() => {
            handleFilterChange();
        }, 500);

        return () => clearTimeout(timeout);
    }, [searchTerm]);

    // Immediate filter for non-search changes
    useEffect(() => {
        handleFilterChange();
    }, [selectedCategory, selectedSort, showFeaturedOnly]);

    // Create helper functions for formatting
    const contentRenderer = (content: any) => renderContent(content);
    const dateFormatter = (dateString: string) => formatDate(dateString, i18n.language);

    return (
        <NavbarLayout>
            <Head title={`${t('blog.pageTitle') || 'News & Updates'} - ${t('company.name')}`} />
            
            <BlogHero />
            
            <BlogFilters
                searchTerm={searchTerm}
                setSearchTerm={setSearchTerm}
                selectedCategory={selectedCategory}
                setSelectedCategory={setSelectedCategory}
                selectedSort={selectedSort}
                setSelectedSort={setSelectedSort}
                showFeaturedOnly={showFeaturedOnly}
                setShowFeaturedOnly={setShowFeaturedOnly}
                categories={categories}
                renderContent={contentRenderer}
            />

            <BlogGrid
                blogs={blogs}
                renderContent={contentRenderer}
                formatDate={dateFormatter}
            />
        </NavbarLayout>
    );
}