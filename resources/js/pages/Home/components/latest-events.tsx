import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { type Event } from '@/types';
import { Calendar, MapPin, Users, Clock, ArrowRight, ArrowLeft } from 'lucide-react';

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
                <div className="mb-12 text-center">
                    <div className="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary/20 to-primary/10">
                        <Calendar className="h-6 w-6 text-primary" />
                    </div>
                    <h2 className={`text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl ${isRTL ? 'font-arabic' : ''}`}>
                        {t('events.latestEvents') || 'Latest Events'}
                    </h2>
                    <p className={`mx-auto mt-2 max-w-2xl text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                        {t('events.latestEventsDescription') || 'Stay updated with our upcoming events and activities'}
                    </p>
                </div>

                {/* Events Grid */}
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    {events.map((event, index) => (
                        <Link
                            key={event.id}
                            href={`/events/${event.slug}`}
                            className="group bg-white rounded-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-primary/10 hover:-translate-y-1 hover:border-primary/20 opacity-0 animate-fade-in-up"
                            style={{
                                animationDelay: `${index * 100}ms`,
                                animationFillMode: 'forwards'
                            }}
                        >
                            {/* Event Image */}
                            <div className="aspect-[16/9] overflow-hidden bg-gradient-to-br from-primary/10 to-primary/5">
                                {event.featured_image ? (
                                    <img
                                        src={event.featured_image}
                                        alt={renderContent(event.title)}
                                        className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        loading="lazy"
                                    />
                                ) : (
                                    <div className="flex h-full w-full items-center justify-center">
                                        <Calendar className="h-12 w-12 text-primary/30" />
                                    </div>
                                )}
                            </div>

                            {/* Event Content */}
                            <div className="p-4">
                                {/* Event Category */}
                                {event.event_category && (
                                    <div className="mb-2">
                                        <span className={`inline-flex items-center rounded-full bg-primary/10 px-2 py-1 text-xs font-medium text-primary ${isRTL ? 'font-arabic' : ''}`}>
                                            {renderContent(event.event_category.name)}
                                        </span>
                                    </div>
                                )}

                                {/* Event Title */}
                                <h3 className={`mb-2 text-lg font-semibold text-gray-900 transition-colors duration-300 group-hover:text-primary line-clamp-2 ${isRTL ? 'font-arabic' : ''}`}>
                                    {renderContent(event.title)}
                                </h3>

                                {/* Event Details */}
                                <div className="space-y-1 mb-3">
                                    {/* Date & Time */}
                                    <div className={`flex items-center gap-2 text-xs text-gray-600 ${isRTL ? '  font-arabic' : ''}`}>
                                        <Clock className="h-3 w-3 text-primary flex-shrink-0" />
                                        <span>
                                            {formatDate(event.start_date)} • {formatTime(event.start_date)}
                                        </span>
                                    </div>

                                    {/* Location */}
                                    {event.location && (
                                        <div className={`flex items-center gap-2 text-xs text-gray-600 ${isRTL ? '  font-arabic' : ''}`}>
                                            <MapPin className="h-3 w-3 text-primary flex-shrink-0" />
                                            <span className="truncate">{event.location}</span>
                                        </div>
                                    )}

                                    {/* Registration Info */}
                                    {event.registration_enabled && (
                                        <div className={`flex items-center gap-2 text-xs text-gray-600 ${isRTL ? '  font-arabic' : ''}`}>
                                            <Users className="h-3 w-3 text-primary flex-shrink-0" />
                                            <span>
                                                {event.capacity 
                                                    ? `${event.registered_count}/${event.capacity} ${t('events.registered') || 'registered'}`
                                                    : `${event.registered_count} ${t('events.registered') || 'registered'}`
                                                }
                                            </span>
                                        </div>
                                    )}
                                </div>

                                {/* Action */}
                                <div className="flex items-center justify-between">
                                    <span className={`text-xs font-medium text-primary group-hover:text-primary-dark transition-colors duration-300 ${isRTL ? 'font-arabic' : ''}`}>
                                        {t('events.viewDetails') || 'View Details'}
                                    </span>
                                    {isRTL ? (
                                        <ArrowLeft className="h-3 w-3 text-primary transition-transform duration-300 group-hover:-translate-x-1" />
                                    ) : (
                                        <ArrowRight className="h-3 w-3 text-primary transition-transform duration-300 group-hover:translate-x-1" />
                                    )}
                                </div>
                            </div>
                        </Link>
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