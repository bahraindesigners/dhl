import NavbarLayout from '@/layouts/navbar-layout';
import { Head, router, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { type SharedData, Event, EventCategory } from '@/types';
import { useState, useEffect } from 'react';

import EventHero from './components/EventHero';
import EventFilters from './components/EventFilters';
import EventGrid from './components/EventGrid';
import { formatDate, formatTime, renderContent } from './utils/eventUtils';

interface EventIndexProps {
    events: {
        data: Event[];
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
    categories: EventCategory[];
    filters: {
        search?: string;
        category?: number;
        status?: string;
        featured?: boolean;
        sort?: string;
    };
}

export default function EventIndex() {
    const { events, categories, filters } = usePage<SharedData & EventIndexProps>().props;
    const { t, i18n } = useTranslation();

    // Local state for filters
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [selectedCategory, setSelectedCategory] = useState(filters.category || '');
    const [selectedStatus, setSelectedStatus] = useState(filters.status || '');
    const [selectedSort, setSelectedSort] = useState(filters.sort || 'date');
    const [showFeaturedOnly, setShowFeaturedOnly] = useState(filters.featured || false);

    // Handle filter changes
    const handleFilterChange = () => {
        const params = new URLSearchParams();
        
        if (searchTerm) params.append('search', searchTerm);
        if (selectedCategory) params.append('category', selectedCategory.toString());
        if (selectedStatus) params.append('status', selectedStatus);
        if (showFeaturedOnly) params.append('featured', '1');
        if (selectedSort !== 'date') params.append('sort', selectedSort);

        router.get('/events', Object.fromEntries(params), {
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
    }, [selectedCategory, selectedStatus, selectedSort, showFeaturedOnly]);

    // Create helper functions for formatting
    const contentRenderer = (content: any) => renderContent(content);
    const dateFormatter = (dateString: string) => formatDate(dateString, i18n.language);
    const timeFormatter = (dateString: string) => formatTime(dateString, i18n.language);

    return (
        <NavbarLayout>
            <Head title={`${t('events.pageTitle') || 'Events'} - ${t('company.name')}`} />
            
            <EventHero />
            
            <EventFilters
                searchTerm={searchTerm}
                setSearchTerm={setSearchTerm}
                selectedCategory={selectedCategory}
                setSelectedCategory={setSelectedCategory}
                selectedStatus={selectedStatus}
                setSelectedStatus={setSelectedStatus}
                selectedSort={selectedSort}
                setSelectedSort={setSelectedSort}
                showFeaturedOnly={showFeaturedOnly}
                setShowFeaturedOnly={setShowFeaturedOnly}
                categories={categories}
                renderContent={contentRenderer}
            />

            <EventGrid
                events={events}
                renderContent={contentRenderer}
                formatDate={dateFormatter}
                formatTime={timeFormatter}
            />
        </NavbarLayout>
    );
}