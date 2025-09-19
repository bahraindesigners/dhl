import { type Blog } from '@/types';
import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { ArrowRight, ArrowLeft } from 'lucide-react';
import BlogCard from '@/pages/Blog/components/BlogCard';

interface LatestNewsProps {
    news?: Blog[];
}

export default function LatestNews({ news = [] }: LatestNewsProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // Helper function to render content - handles both HTML strings and TipTap JSON
    const renderContent = (content: any): string => {
        // If content is already a string (HTML), return it directly
        if (typeof content === 'string') {
            return content;
        }

        // Handle multilingual object format
        if (typeof content === 'object' && content !== null && !content.type) {
            // Use current backend locale, fallback to English, then first available
            const currentLocale = i18n.language || 'en';
            return content[currentLocale] ||
                content['en'] ||
                Object.values(content)[0] ||
                '';
        }

        // Handle TipTap JSON format (basic support)
        if (content && typeof content === 'object' && content.type === 'doc') {
            // For now, return empty string for TipTap - the BlogCard's ContentCard will handle this
            return '';
        }
        
        // Fallback for any other format
        return String(content || '');
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
                <div className={`flex items-center gap-3 mb-4 `}>
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
                {news.slice(0, 6).map((article, index) => (
                    <BlogCard 
                        key={article.id} 
                        blog={article}
                        index={index}
                        renderContent={renderContent}
                        formatDate={formatDate}
                    />
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