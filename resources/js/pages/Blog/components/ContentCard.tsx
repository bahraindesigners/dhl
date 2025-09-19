import { Blog, Event } from '@/types';
import { Link } from '@inertiajs/react';
import { ArrowLeft, ArrowRight, BookOpen, Calendar, Clock, Eye, MapPin, Users } from 'lucide-react';
import { useTranslation } from 'react-i18next';

interface ContentCardProps {
    item: Blog | Event;
    index: number;
    renderContent: (content: any) => string;
    formatDate: (dateString: string) => string;
    formatTime?: (dateString: string) => string;
    type: 'blog' | 'event';
    href: string;
}

export default function ContentCard({ item, index, renderContent, formatDate, formatTime, type, href }: ContentCardProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    const isBlog = type === 'blog';
    const isEvent = type === 'event';
    const blog = item as Blog;
    const event = item as Event;

    // Helper function to get category colors
    const getCategoryColors = () => {
        let categoryColor: string | undefined;

        if (isBlog && blog.blog_category?.color) {
            categoryColor = blog.blog_category.color;
        } else if (isEvent && event.event_category?.color) {
            categoryColor = event.event_category.color;
        }

        if (categoryColor) {
            // If color is a hex code, create background and text color variants
            if (categoryColor.startsWith('#')) {
                return {
                    bg: `bg-[${categoryColor}1A]`, // 10% opacity
                    text: `text-[${categoryColor}]`,
                    style: {
                        backgroundColor: `${categoryColor}1A`, // 10% opacity
                        color: categoryColor,
                    },
                };
            }
            // If color is a CSS color name or Tailwind class
            return {
                bg: `bg-${categoryColor}/10`,
                text: `text-${categoryColor}`,
                style: {},
            };
        }

        // Fallback to primary colors
        return {
            bg: 'bg-primary/10',
            text: 'text-primary',
            style: {},
        };
    };

    const categoryColors = getCategoryColors();

    return (
        <Link
            href={href}
            className="group animate-fade-in-up overflow-hidden rounded-xl border border-gray-100 bg-white opacity-0 transition-all duration-300 hover:-translate-y-1 hover:border-primary/20 hover:shadow-lg hover:shadow-primary/10"
            style={{
                animationDelay: `${index * 100}ms`,
                animationFillMode: 'forwards',
            }}
        >
            {/* Featured Badge - only for blogs */}
            {isBlog && blog.featured && (
                <div className="absolute top-4 left-4 z-10">
                    <span className="inline-flex items-center rounded-full bg-primary px-2 py-1 text-xs font-medium text-white">
                        {t('blog.featured') || 'Featured'}
                    </span>
                </div>
            )}

            {/* Image */}
            <div className="aspect-[16/9] overflow-hidden bg-gradient-to-br from-primary/10 to-primary/5">
                {item.featured_image ? (
                    <img
                        src={item.featured_image}
                        alt={renderContent(item.title)}
                        className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        loading="lazy"
                    />
                ) : (
                    <div className="flex h-full w-full items-center justify-center">
                        {isBlog ? <BookOpen className="h-12 w-12 text-primary/30" /> : <Calendar className="h-12 w-12 text-primary/30" />}
                    </div>
                )}
            </div>

            {/* Content */}
            <div className="p-4">
                {/* Category */}
                {((isBlog && blog.blog_category) || (isEvent && event.event_category)) && (
                    <div className="mb-2">
                        <span
                            className={`inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ${categoryColors.bg} ${categoryColors.text} ${isRTL ? 'font-arabic' : ''}`}
                            style={categoryColors.style}
                        >
                            {isBlog ? renderContent(blog.blog_category?.name) : renderContent(event.event_category?.name)}
                        </span>
                    </div>
                )}

                {/* Title */}
                <h3
                    className={`mb-2 line-clamp-2 text-lg font-semibold text-gray-900 transition-colors duration-300 group-hover:text-primary ${isRTL ? 'font-arabic' : ''}`}
                >
                    {renderContent(item.title)}
                </h3>

                {/* Excerpt - only for blogs */}
                {isBlog && blog.excerpt && (
                    <div
                        className={`prose prose-xs prose-p:m-0 prose-p:text-xs prose-p:text-gray-600 mb-3 line-clamp-2 max-w-none text-xs leading-relaxed text-gray-600 ${isRTL ? 'font-arabic text-right' : ''}`}
                        dangerouslySetInnerHTML={{ __html: renderContent(blog.excerpt) }}
                    />
                )}

                {/* Meta Information */}
                <div className="mb-3 space-y-1">
                    {isBlog ? (
                        <>
                            {/* Blog: Date & Author */}
                            <div className={`flex items-center gap-2 text-xs text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                <Calendar className="h-3 w-3 flex-shrink-0 text-primary" />
                                <span>{formatDate(blog.published_at)}</span>
                                {blog.author && (
                                    <>
                                        <span>•</span>
                                        <span>{blog.author}</span>
                                    </>
                                )}
                            </div>

                            {/* Blog: Reading Time & Views */}
                            <div className={`flex items-center gap-2 text-xs text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                <Clock className="h-3 w-3 flex-shrink-0 text-primary" />
                                <span>
                                    {blog.reading_time} {t('blog.minRead') || 'min read'}
                                </span>
                                <span>•</span>
                                <Eye className="h-3 w-3 flex-shrink-0 text-primary" />
                                <span>
                                    {blog.views_count} {t('blog.views') || 'views'}
                                </span>
                            </div>
                        </>
                    ) : (
                        <>
                            {/* Event: Date & Time */}
                            <div className={`flex items-center gap-2 text-xs text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                <Clock className="h-3 w-3 flex-shrink-0 text-primary" />
                                <span>
                                    {formatDate(event.start_date)} • {formatTime ? formatTime(event.start_date) : ''}
                                </span>
                            </div>

                            {/* Event: Location */}
                            {event.location && (
                                <div className={`flex items-center gap-2 text-xs text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                    <MapPin className="h-3 w-3 flex-shrink-0 text-primary" />
                                    <span className="truncate">{event.location}</span>
                                </div>
                            )}

                            {/* Event: Registration Info */}
                            {event.registration_enabled && (
                                <div className={`flex items-center gap-2 text-xs text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                    <Users className="h-3 w-3 flex-shrink-0 text-primary" />
                                    <span>
                                        {event.capacity
                                            ? `${event.registered_count}/${event.capacity} ${t('events.registered') || 'registered'}`
                                            : `${event.registered_count} ${t('events.registered') || 'registered'}`}
                                    </span>
                                </div>
                            )}
                        </>
                    )}
                </div>

                {/* Action */}
                <div className="flex items-center justify-start gap-1">
                    {isRTL ? (
                        <ArrowLeft className="h-3 w-3 text-primary transition-transform duration-300 group-hover:-translate-x-1" />
                    ) : (
                        <ArrowRight className="h-3 w-3 text-primary transition-transform duration-300 group-hover:translate-x-1" />
                    )}
                    <span
                        className={`group-hover:text-primary-dark text-xs font-medium text-primary transition-colors duration-300 ${isRTL ? 'font-arabic' : ''}`}
                    >
                        {isBlog ? t('blog.readMore') || 'Read More' : t('events.viewDetails') || 'View Details'}
                    </span>
                </div>
            </div>
        </Link>
    );
}
