import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { type Event } from '@/types';
import { Calendar, ArrowRight, ArrowLeft } from 'lucide-react';
import EventCard from './EventCard';

interface LatestEventsProps {
    events: Event[];
}

export default function LatestEvents({ events }: LatestEventsProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // Helper function to render content - handles both HTML strings and TipTap JSON
    const renderContent = (content: any): string => {
        // If content is already a string (HTML), return it directly
        if (typeof content === 'string') {
            return content;
        }
        
        // Fallback for any other format
        return String(content || '');
    };

    // Helper function to format date
    const formatDate = (dateString: string): string => {
        const date = new Date(dateString);
        return date.toLocaleDateString(i18n.language === 'ar' ? 'ar-BH' : 'en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    };

    // Helper function to format time
    const formatTime = (dateString: string): string => {
        const date = new Date(dateString);
        return date.toLocaleTimeString(i18n.language === 'ar' ? 'ar-BH' : 'en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    if (events.length === 0) {
        return null;
    }

    return (
        <section className={`py-12 sm:py-16 bg-gray-50 ${isRTL ? 'rtl' : ''}`}>
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {/* Section Header */}
                <div className="mb-12 text-start">

                    <div className={`flex items-center gap-3 mb-4 `}>
                    <div className="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-primary text-white">
                        <Calendar className="h-6 w-6 text-white" />
                    </div>
                    <h3 className={`text-xl sm:text-2xl font-bold text-foreground ${isRTL ? 'font-arabic' : ''}`}>
                        {t('events.latestEvents') || 'Latest Events'}
                    </h3>
                </div>
                    <p className={`mx-auto mt-2  text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                        {t('events.latestEventsDescription') || 'Stay updated with our upcoming events and activities'}
                    </p>
                </div>

                {/* Events Grid */}
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    {events.map((event, index) => (
                        <EventCard
                            key={event.id}
                            event={event}
                            index={index}
                            renderContent={renderContent}
                            formatDate={formatDate}
                            formatTime={formatTime}
                        />
                    ))}
                </div>

                {/* View All Events Button */}
                <div className="mt-8 text-center">
                    <Link
                        href="/events"
                        className={`inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 font-medium text-white transition-all duration-300 hover:bg-primary-dark hover:scale-105 hover:shadow-lg hover:shadow-primary/25 ${isRTL ? '  font-arabic' : ''}`}
                    >
                        <span>{t('events.viewAllEvents') || 'View All Events'}</span>
                        {isRTL ? (
                            <ArrowLeft className="h-4 w-4" />
                        ) : (
                            <ArrowRight className="h-4 w-4" />
                        )}
                    </Link>
                </div>
            </div>
        </section>
    );
}