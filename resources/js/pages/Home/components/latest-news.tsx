import { type Blog } from '@/types';
import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { Clock, Eye, ArrowRight, ArrowLeft } from 'lucide-react';

interface LatestNewsProps {
    news?: Blog[];
}

export default function LatestNews({ news = [] }: LatestNewsProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // Helper function to get content - works with both old and new format
    const getContent = (content: string | Record<string, string>): string => {
        if (typeof content === 'string') {
            return content;
        }

        if (typeof content === 'object' && content !== null) {
            // Use current backend locale, fallback to English, then first available
            const currentLocale = i18n.language || 'en';
            return content[currentLocale] ||
                content['en'] ||
                Object.values(content)[0] ||
                '';
        }

        return '';
    };

    const formatDate = (dateString: string): string => {
        const date = new Date(dateString);
        return date.toLocaleDateString(isRTL ? 'ar-BH' : 'en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    if (!news || news.length === 0) {
        return null;
    }

    return (
        <div className="mt-16 sm:mt-20">
            {/* Section Header - Simplified */}
            <div className="mb-8 sm:mb-12">
                <div className={`flex items-center gap-3 mb-4 ${isRTL ? 'flex-row-reverse' : ''}`}>
                    <div className="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-primary text-white">
                        <svg className="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3v8m4-4h-4m-4-4h4m-4 4h4" />
                        </svg>
                    </div>
                    <h3 className={`text-xl sm:text-2xl font-bold text-foreground ${isRTL ? 'font-arabic' : ''}`}>
                        {t('home.latestNews')}
                    </h3>
                </div>
                <p className={`text-sm sm:text-base text-muted-foreground ${isRTL ? 'font-arabic text-right' : ''}`}>
                    {t('home.latestNewsDescription')}
                </p>
            </div>

            {/* News Grid - Mobile First */}
            <div className="grid gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
                {news.slice(0, 6).map((article) => (
                    <Link
                        key={article.id}
                        href={`/news/${getContent(article.slug)}`}
                        className="group block"
                    >
                        <article className="bg-white rounded-2xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-primary/5 hover:-translate-y-1">
                            {/* Image Container - Optimized aspect ratio */}
                            <div className="relative aspect-[16/10] bg-gradient-to-br from-primary/8 to-primary/3 overflow-hidden">
                                {article.featured_image ? (
                                    <img
                                        src={article.featured_image}
                                        alt={getContent(article.title)}
                                        className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy"
                                    />
                                ) : (
                                    <div className="flex items-center justify-center h-full">
                                        <svg className="h-12 w-12 text-primary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                )}

                                {/* Badges - Minimal Design */}
                                <div className={`absolute top-3 ${isRTL ? 'right-3' : 'left-3'} flex gap-2`}>
                                    {article.featured && (
                                        <span className="bg-primary text-white px-2 py-1 rounded-md text-xs font-medium backdrop-blur-sm">
                                            {t('news.featured')}
                                        </span>
                                    )}
                                    {article.show_as_urgent_news && (
                                        <span className="bg-red-500 text-white px-2 py-1 rounded-md text-xs font-medium backdrop-blur-sm animate-pulse">
                                            {t('news.urgent')}
                                        </span>
                                    )}
                                </div>
                            </div>

                            {/* Content - Compact Layout */}
                            <div className="p-4 sm:p-5">
                                {/* Category & Meta Row */}
                                <div className={`flex items-center justify-between mb-3 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                    {article.blog_category && (
                                        <span className="text-xs font-medium text-primary bg-primary/8 px-2 py-1 rounded-lg">
                                            {getContent(article.blog_category.name)}
                                        </span>
                                    )}
                                    <div className={`flex items-center gap-2 text-xs text-gray-500 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                        <Clock className="h-3 w-3" />
                                        <span>{article.reading_time}{t('news.minRead')}</span>
                                    </div>
                                </div>

                                {/* Title - More Compact */}
                                <h3 className={`text-base sm:text-lg font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-300 ${isRTL ? 'font-arabic text-right' : ''}`}>
                                    {getContent(article.title)}
                                </h3>

                                {/* Excerpt - Reduced */}
                                <p className={`text-sm text-gray-600 line-clamp-2 mb-3 leading-relaxed ${isRTL ? 'font-arabic text-right' : ''}`}>
                                    {getContent(article.excerpt)}
                                </p>

                                {/* Bottom Meta - Simplified */}
                                <div className={`flex items-center justify-between text-xs text-gray-500 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                    <div className={`flex items-center gap-1 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                        <Eye className="h-3 w-3" />
                                        <span>{article.views_count}</span>
                                    </div>
                                    <time className={isRTL ? 'font-arabic' : ''}>
                                        {new Date(article.published_at).toLocaleDateString(
                                            isRTL ? 'ar-BH' : 'en-US',
                                            { month: 'short', day: 'numeric' }
                                        )}
                                    </time>
                                </div>
                            </div>
                        </article>
                    </Link>
                ))}
            </div>

            {/* View All Button - Simplified */}
            <div className="text-center mt-8 sm:mt-12">
                <Link
                    href="/news"
                    className={`inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-medium hover:bg-primary/90 transition-all duration-300 hover:scale-105 text-sm sm:text-base ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}
                >
                    <span>{t('news.viewAllNews')}</span>
                    {isRTL ? (
                        <ArrowLeft className="h-4 w-4" />
                    ) : (
                        <ArrowRight className="h-4 w-4" />
                    )}
                </Link>
            </div>
        </div>
    );
}