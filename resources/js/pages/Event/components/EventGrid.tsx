import { useTranslation } from 'react-i18next';
import { router } from '@inertiajs/react';
import { Calendar } from 'lucide-react';
import EventCard from '../../Home/components/EventCard';
import { Event } from '@/types';

interface EventGridProps {
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
    renderContent: (content: any) => string;
    formatDate: (dateString: string) => string;
    formatTime: (dateString: string) => string;
}

export default function EventGrid({ events, renderContent, formatDate, formatTime }: EventGridProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    return (
        <section className={`py-16 bg-gray-50 ${isRTL ? 'rtl' : ''}`}>
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {events.data.length > 0 ? (
                    <>
                        {/* Results count */}
                        <div className={`mb-8 text-sm text-gray-600 ${isRTL ? 'text-right font-arabic' : ''}`}>
                            {t('events.resultsCount', { count: events.total }) || `${events.total} events found`}
                        </div>

                        {/* Event Grid */}
                        <div className="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            {events.data.map((event, index) => (
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

                        {/* Pagination */}
                        {events.links && events.links.length > 3 && (
                            <div className="mt-12 flex justify-center">
                                <nav className={`flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                    {events.links.map((link, index) => (
                                        <button
                                            key={index}
                                            onClick={() => link.url && router.visit(link.url)}
                                            disabled={!link.url}
                                            className={`px-3 py-2 text-sm rounded-lg transition-colors duration-200 ${
                                                link.active 
                                                    ? 'bg-primary text-white' 
                                                    : link.url 
                                                        ? 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300' 
                                                        : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                            } ${isRTL ? 'font-arabic' : ''}`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </nav>
                            </div>
                        )}
                    </>
                ) : (
                    /* No Results */
                    <div className="text-center py-16">
                        <Calendar className="mx-auto h-16 w-16 text-gray-300 mb-4" />
                        <h3 className={`text-lg font-medium text-gray-900 mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('events.noResults') || 'No events found'}
                        </h3>
                        <p className={`text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('events.noResultsDescription') || 'Try adjusting your search or filter criteria.'}
                        </p>
                    </div>
                )}
            </div>
        </section>
    );
}