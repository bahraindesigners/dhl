import NavbarLayout from '@/layouts/navbar-layout';
import { Head, Link, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { type SharedData, Event } from '@/types';
import { Calendar, MapPin, Clock, Users, User, DollarSign, Eye, CheckCircle, AlertCircle, XCircle } from 'lucide-react';
import PhotoSwipeLightbox from 'photoswipe/lightbox';
import 'photoswipe/style.css';
import { useState, useEffect, useRef } from 'react';
import EventCard from '../Home/components/EventCard';
import { formatEventDate, formatEventTime, getEventStatus, getDaysUntil } from './utils/eventUtils';

interface EventShowProps {
    event: Event;
    relatedEvents: Event[];
}

export default function EventShow() {
    const { event, relatedEvents } = usePage<SharedData & EventShowProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';
    const galleryRef = useRef<HTMLDivElement>(null);

    // Helper function to render content - handles both HTML strings and TipTap JSON
    const tiptapToHtml = (tiptapJson: any): string => {
        if (typeof tiptapJson === 'string') {
            return tiptapJson;
        }

        if (!tiptapJson || !tiptapJson.content) {
            return '';
        }

        const processNode = (node: any): string => {
            if (node.type === 'paragraph') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                if (!content.trim()) {
                    return '<p><br></p>'; // Preserve empty paragraphs for line breaks
                }
                return `<p>${content}</p>`;
            }

            if (node.type === 'text') {
                return node.text || '';
            }

            if (node.type === 'heading') {
                const level = node.attrs?.level || 1;
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<h${level}>${content}</h${level}>`;
            }

            if (node.type === 'bulletList') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<ul>${content}</ul>`;
            }

            if (node.type === 'orderedList') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<ol>${content}</ol>`;
            }

            if (node.type === 'listItem') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<li>${content}</li>`;
            }

            if (node.type === 'blockquote') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<blockquote>${content}</blockquote>`;
            }

            if (node.content) {
                return node.content.map(processNode).join('');
            }

            return '';
        };

        return tiptapJson.content.map(processNode).join('');
    };

    // Get content based on language
    const getContent = (content: any) => {
        if (typeof content === 'string') {
            return content;
        }
        if (content && typeof content === 'object' && content.type === 'doc') {
            return tiptapToHtml(content);
        }
        if (typeof content === 'object' && content !== null) {
            return content[i18n.language] || content.en || '';
        }
        return '';
    };

    const eventTitle = typeof event.title === 'string' ? event.title : event.title[i18n.language] || event.title.en;
    const eventDescription = typeof event.description === 'string' ? event.description : event.description[i18n.language] || event.description.en;
    const contentHtml = tiptapToHtml(event.content);

    // Initialize PhotoSwipe for gallery
    useEffect(() => {
        if (!galleryRef.current || !event.gallery || event.gallery.length === 0) return;

        const lightbox = new PhotoSwipeLightbox({
            gallery: galleryRef.current,
            children: 'a',
            pswpModule: () => import('photoswipe'),
            showHideOpacity: true,
            bgOpacity: 0.9,
            spacing: 0.1,
            allowPanToNext: false,
            zoom: true,
            close: true,
            arrowKeys: true,
            returnFocus: false,
            wheelToZoom: true,
            clickToCloseNonZoomable: false,
            closeOnVerticalDrag: true,
            padding: { top: 20, bottom: 40, left: 100, right: 100 },
            imageClickAction: 'zoom',
            tapAction: 'zoom',
            doubleTapAction: 'zoom',
        });

        lightbox.init();

        return () => {
            lightbox.destroy();
        };
    }, [event.gallery]);

    // Helper function to get category badge styles
    const getCategoryBadgeStyles = () => {
        if (!event.event_category?.color) {
            return {
                backgroundColor: 'rgba(107, 114, 128, 0.1)', // gray-500 with 10% opacity
                color: '#6b7280' // gray-500 full opacity
            };
        }

        const color = event.event_category.color;

        // Convert hex to RGB for alpha channel
        const hex = color.replace('#', '');
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);

        return {
            backgroundColor: `rgba(${r}, ${g}, ${b}, 0.1)`,
            color: color
        };
    };

    // Get event status and styling
    const eventStatus = getEventStatus(event.start_date, event.end_date);
    const daysUntil = getDaysUntil(event.start_date);

    const getStatusIcon = () => {
        switch (eventStatus) {
            case 'upcoming':
                return <Clock className="h-4 w-4" />;
            case 'ongoing':
                return <CheckCircle className="h-4 w-4" />;
            case 'past':
                return <XCircle className="h-4 w-4" />;
            default:
                return <Calendar className="h-4 w-4" />;
        }
    };

    const getStatusText = () => {
        switch (eventStatus) {
            case 'upcoming':
                return daysUntil > 0 ? `${daysUntil} days until event` : 'Event starts today';
            case 'ongoing':
                return 'Event is happening now';
            case 'past':
                return 'Event has ended';
            default:
                return 'Event';
        }
    };

    const getStatusColor = () => {
        switch (eventStatus) {
            case 'upcoming':
                return 'text-blue-600';
            case 'ongoing':
                return 'text-green-600';
            case 'past':
                return 'text-gray-500';
            default:
                return 'text-gray-600';
        }
    };

    // Format date and time
    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return date.toLocaleDateString(i18n.language === 'ar' ? 'ar-BH' : 'en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    const formatTime = (dateString: string) => {
        const date = new Date(dateString);
        return date.toLocaleTimeString(i18n.language === 'ar' ? 'ar-BH' : 'en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    };

    return (
        <NavbarLayout>
            <Head title={`${eventTitle} - ${t('company.name')}`} />

            <div className="bg-white">
                {/* Hero Section */}
                <div className="relative bg-gradient-to-b from-slate-50 to-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16">
                        <div className="max-w-4xl mx-auto">
                            {/* Category Badge */}
                            {event.event_category && (
                                <div className="mb-6">
                                    <span
                                        className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                        style={getCategoryBadgeStyles()}
                                    >
                                        {typeof event.event_category.name === 'string'
                                            ? event.event_category.name
                                            : event.event_category.name[i18n.language] || event.event_category.name.en}
                                    </span>
                                </div>
                            )}

                            {/* Title */}
                            <h1 className={`text-4xl md:text-5xl font-bold text-slate-900 mb-6 leading-tight ${isRTL ? 'font-arabic' : ''}`}>
                                {eventTitle}
                            </h1>

                            {/* Description */}
                            {eventDescription && (
                                <p className={`text-xl text-slate-600 mb-2 leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>
                                    {eventDescription}
                                </p>
                            )}

                            {/* Event Status */}
                            <div className={`flex items-center gap-2 mb-6 ${getStatusColor()}`}>
                                {getStatusIcon()}
                                <span className={`font-medium ${isRTL ? 'font-arabic' : ''}`}>
                                    {getStatusText()}
                                </span>
                            </div>


                        </div>
                    </div>
                </div>

                {/* Featured Image */}
                {event.featured_image && (
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8  mb-16">
                        <div className="max-w-4xl mx-auto">
                            <div className="relative aspect-video rounded-2xl overflow-hidden shadow-xl">
                                <img
                                    src={event.featured_image}
                                    alt={eventTitle}
                                    className="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                    </div>
                )}
                <div className='max-w-4xl mx-auto px-4 sm:px-6 lg:px-0'>
                    {/* Meta Information */}
                    <div className="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200/60 p-8 shadow-sm ">
                        <div className={`grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 ${isRTL ? 'text-right' : ''}`}>
                            {/* Date & Time */}
                            <div className="group">
                                <div className="flex items-start gap-4">
                                    <div className="flex-shrink-0">
                                        <div className="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-200">
                                            <Calendar className="h-6 w-6 text-blue-600" />
                                        </div>
                                    </div>
                                    <div className="flex-grow min-w-0">
                                        <div className={`text-sm font-semibold text-slate-900 mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                                            {t('events.dateTime') || 'Date & Time'}
                                        </div>
                                        {/* <div className={`text-sm text-slate-700 font-medium mb-1 ${isRTL ? 'font-arabic' : ''}`}>
                                            {formatEventDate(event.start_date, event.end_date, i18n.language)}
                                        </div> */}
                                        <div className={`text-sm text-slate-700 font-medium mb-1 ${isRTL ? 'font-arabic' : ''}`}>
                                            {formatEventTime(event.start_date, event.end_date, i18n.language)}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Location */}
                            {event.location && (
                                <div className="group">
                                    <div className="flex items-start gap-4">
                                        <div className="flex-shrink-0">
                                            <div className="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors duration-200">
                                                <MapPin className="h-6 w-6 text-emerald-600" />
                                            </div>
                                        </div>
                                        <div className="flex-grow min-w-0">
                                            <div className={`text-sm font-semibold text-slate-900 mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                {t('events.location') || 'Location'}
                                            </div>
                                            <div className={`text-sm text-slate-700 font-medium ${isRTL ? 'font-arabic' : ''}`}>
                                                {event.location}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Organizer */}
                            {event.organizer && (
                                <div className="group">
                                    <div className="flex items-start gap-4">
                                        <div className="flex-shrink-0">
                                            <div className="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center group-hover:bg-purple-100 transition-colors duration-200">
                                                <User className="h-6 w-6 text-purple-600" />
                                            </div>
                                        </div>
                                        <div className="flex-grow min-w-0">
                                            <div className={`text-sm font-semibold text-slate-900 mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                {t('events.organizer') || 'Organizer'}
                                            </div>
                                            <div className={`text-sm text-slate-700 font-medium ${isRTL ? 'font-arabic' : ''}`}>
                                                {typeof event.organizer === 'string' ? event.organizer : event.organizer[i18n.language] || event.organizer.en}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Capacity & Registration */}
                            {event.registration_enabled && (
                                <div className="group">
                                    <div className="flex items-start gap-4">
                                        <div className="flex-shrink-0">
                                            <div className="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center group-hover:bg-orange-100 transition-colors duration-200">
                                                <Users className="h-6 w-6 text-orange-600" />
                                            </div>
                                        </div>
                                        <div className="flex-grow min-w-0">
                                            <div className={`text-sm font-semibold text-slate-900 mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                {t('events.capacity') || 'Capacity'}
                                            </div>
                                            <div className={`text-sm text-slate-700 font-medium mb-1 ${isRTL ? 'font-arabic' : ''}`}>
                                                {event.registered_count}{event.capacity ? ` / ${event.capacity}` : ''} registered
                                            </div>
                                            {event.spots_remaining && (
                                                <div className={`text-sm text-green-600 font-medium ${isRTL ? 'font-arabic' : ''}`}>
                                                    {event.spots_remaining} spots left
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Price */}
                            {event.price !== undefined && (
                                <div className="group">
                                    <div className="flex items-start gap-4">
                                        <div className="flex-shrink-0">
                                            <div className="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center group-hover:bg-indigo-100 transition-colors duration-200">
                                                <DollarSign className="h-6 w-6 text-indigo-600" />
                                            </div>
                                        </div>
                                        <div className="flex-grow min-w-0">
                                            <div className={`text-sm font-semibold text-slate-900 mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                {t('events.price') || 'Price'}
                                            </div>
                                            <div className={`text-lg text-slate-700 font-bold ${isRTL ? 'font-arabic' : ''}`}>
                                                {event.price === "0.00" ? (
                                                    <span className="text-green-600">Free</span>
                                                ) : (
                                                    <span className="text-slate-900">BHD {event.price}</span>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Registration Button */}
                    {event.can_register && event.registration_enabled && eventStatus === 'upcoming' && (
                        <div className="mt-8">
                            <button className="bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary/90 transition-colors">
                                {t('events.register') || 'Register Now'}
                            </button>
                        </div>
                    )}
                </div>
                {/* Main Content */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                    <div className="max-w-4xl mx-auto">
                        {/* Event Content */}
                        {contentHtml && (
                            <div className={`prose prose-lg max-w-none prose-slate mb-16 ${isRTL ? 'prose-rtl' : ''}`}>
                                <div
                                    className={`tiptap-content ${isRTL ? 'font-arabic' : ''}`}
                                    dangerouslySetInnerHTML={{ __html: contentHtml }}
                                />
                            </div>
                        )}

                        {/* Event Gallery */}
                        {event.gallery && event.gallery.length > 0 && (
                            <div className="mb-16">
                                <h3 className={`text-2xl font-bold text-slate-900 mb-8 ${isRTL ? 'font-arabic' : ''}`}>
                                    {t('events.gallery') || 'Event Gallery'}
                                </h3>
                                <div ref={galleryRef} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    {event.gallery.map((image, index) => (
                                        <a
                                            key={image.id}
                                            href={image.url}
                                            data-pswp-width={image.width}
                                            data-pswp-height={image.height}
                                            className="block relative aspect-square rounded-lg overflow-hidden hover:opacity-90 transition-opacity group"
                                        >
                                            <img
                                                src={image.thumb || image.url}
                                                alt={image.alt || `Gallery image ${index + 1}`}
                                                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                                loading="lazy"
                                            />
                                            <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                                        </a>
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* Additional Event Details */}
                        {(event.location_details || event.organizer_details) && (
                            <div className="mb-16 grid grid-cols-1 md:grid-cols-2 gap-8">
                                {event.location_details && (
                                    <div>
                                        <h3 className={`text-xl font-bold text-slate-900 mb-4 ${isRTL ? 'font-arabic' : ''}`}>
                                            {t('events.locationDetails') || 'Location Details'}
                                        </h3>
                                        <div className={`text-slate-600 ${isRTL ? 'font-arabic' : ''}`}>
                                            {getContent(event.location_details)}
                                        </div>
                                    </div>
                                )}

                                {event.organizer_details && (
                                    <div>
                                        <h3 className={`text-xl font-bold text-slate-900 mb-4 ${isRTL ? 'font-arabic' : ''}`}>
                                            {t('events.organizerDetails') || 'About the Organizer'}
                                        </h3>
                                        <div className={`text-slate-600 ${isRTL ? 'font-arabic' : ''}`}>
                                            {getContent(event.organizer_details)}
                                        </div>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </div>

                {/* Related Events */}
                {relatedEvents && relatedEvents.length > 0 && (
                    <div className="bg-gray-50 py-16">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div className="text-center mb-12">
                                <h2 className={`text-3xl font-bold text-slate-900 ${isRTL ? 'font-arabic' : ''}`}>
                                    {t('events.relatedEvents') || 'Related Events'}
                                </h2>
                                <p className={`mt-4 text-lg text-slate-600 ${isRTL ? 'font-arabic' : ''}`}>
                                    {t('events.relatedEventsDescription') || 'Discover more events you might be interested in'}
                                </p>
                            </div>

                            <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                                {relatedEvents.map((relatedEvent, index) => (
                                    <EventCard
                                        key={relatedEvent.id}
                                        event={relatedEvent}
                                        index={index}
                                        renderContent={getContent}
                                        formatDate={formatDate}
                                        formatTime={formatTime}
                                    />
                                ))}
                            </div>

                            <div className="text-center mt-12">
                                <Link
                                    href="/events"
                                    className="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary/90 transition-colors"
                                >
                                    <Calendar className="h-5 w-5" />
                                    {t('events.viewAllEvents') || 'View All Events'}
                                </Link>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </NavbarLayout>
    );
}