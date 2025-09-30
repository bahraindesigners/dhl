import { type Blog } from '@/types';
import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { ChevronLeft, ChevronRight, AlertTriangle } from 'lucide-react';
import { useRef, useState } from 'react';
import Slider from 'react-slick';

interface UrgentNewsSliderProps {
    urgentNews?: Blog[];
    autoPlay?: boolean;
    autoPlayInterval?: number;
}

export default function UrgentNewsSlider({
    urgentNews = [],
    autoPlay = true, // Re-enable autoplay with longer interval
    autoPlayInterval = 8000 // Increase to 8 seconds
}: UrgentNewsSliderProps) {
    const sliderRef = useRef<Slider>(null);
    const [currentSlide, setCurrentSlide] = useState(0);
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // Use the urgent news directly since it's already filtered
    const filteredUrgentNews = urgentNews;

    // Since backend sends content in current language, we can use it directly
    const renderContent = (content: any): string => {
        return String(content || '');
    };

    const formatDate = (dateString: string): string => {
        const date = new Date(dateString);
        return date.toLocaleDateString(isRTL ? 'ar-BH' : 'en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    };

    const goToPrevSlide = () => {
        sliderRef.current?.slickPrev();
    };

    const goToNextSlide = () => {
        sliderRef.current?.slickNext();
    };

    // Don't render if no urgent news
    if (!filteredUrgentNews || filteredUrgentNews.length === 0) {
        return null;
    }

    const sliderSettings = {
        dots: false,
        infinite: filteredUrgentNews.length > 1,
        speed: 800,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: autoPlay && filteredUrgentNews.length > 1,
        autoplaySpeed: autoPlayInterval,
        arrows: false,
        rtl: isRTL,
        pauseOnHover: true,
        pauseOnFocus: true,
        pauseOnDotsHover: true,
        waitForAnimate: false,
        beforeChange: (current: number, next: number) => setCurrentSlide(next)
    };

    return (
        <div className="mt-12 sm:mt-16">
            {/* Section Header */}
            <div className="mb-6">
                <div className={`flex items-center gap-3 mb-4 `}>
                    <div className="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-red-600 text-white">
                        <AlertTriangle className="h-5 w-5 sm:h-6 sm:w-6" />
                    </div>
                    <h3 className={`text-xl sm:text-2xl font-bold text-foreground ${isRTL ? 'font-arabic' : ''}`}>
                        {t('home.urgentNews')}
                    </h3>
                </div>
            </div>

            {/* Urgent News Slider Container */}
            <div className="relative px-8 sm:px-0">
                <div className="bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-xl overflow-hidden shadow-sm">
                    <Slider ref={sliderRef} {...sliderSettings}>
                        {filteredUrgentNews.map((news, index) => (
                            <div key={news.id}>
                                <div className="p-4 sm:p-6 md:p-8">
                                    {/* Urgent Badge - Always on top */}
                                    <div className={`mb-3 sm:mb-4 ${isRTL ? 'text-right' : 'text-left'}`}>
                                        <span className="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <AlertTriangle className="h-3 w-3" />
                                            <span className={isRTL ? 'font-arabic' : ''}>
                                                {t('news.urgent')}
                                            </span>
                                        </span>
                                    </div>

                                    {/* News Content */}
                                    <div className="space-y-3 sm:space-y-4">
                                        <h4 className={`text-base sm:text-lg md:text-xl font-semibold text-gray-900 line-clamp-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                            {renderContent(news.title)}
                                        </h4>
                                        
                                        <p className={`text-sm sm:text-base text-gray-600 line-clamp-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                            {renderContent(news.excerpt || news.content)}
                                        </p>

                                        <div className={`flex items-center justify-between ${isRTL ? 'flex-row-reverse' : ''}`}>
                                            <span className={`text-xs sm:text-sm text-gray-500 ${isRTL ? 'font-arabic' : ''}`}>
                                                {formatDate(news.published_at)}
                                            </span>
                                            
                                            <Link
                                                href={`/news/${news.id}`}
                                                className={`inline-flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium transition-colors ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}
                                            >
                                                <span>{t('news.readMore')}</span>
                                                {isRTL ? (
                                                    <ChevronLeft className="h-4 w-4" />
                                                ) : (
                                                    <ChevronRight className="h-4 w-4" />
                                                )}
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </Slider>

                    {/* Slide Indicators */}
                    {filteredUrgentNews.length > 1 && (
                        <div className="absolute bottom-4 sm:bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                            {filteredUrgentNews.map((_, index) => (
                                <button
                                    key={index}
                                    onClick={() => sliderRef.current?.slickGoTo(index)}
                                    className={`h-2 w-6 sm:w-8 rounded-full transition-colors ${
                                        index === currentSlide 
                                            ? 'bg-red-400' 
                                            : 'bg-red-200 hover:bg-red-400'
                                    }`}
                                    aria-label={`Go to slide ${index + 1}`}
                                />
                            ))}
                        </div>
                    )}
                </div>

                {/* Navigation Arrows - Outside the card on desktop, below on mobile */}
                {filteredUrgentNews.length > 1 && (
                    <>
                        {/* Desktop Navigation Arrows */}
                        <button
                            onClick={isRTL ? goToNextSlide : goToPrevSlide}
                            className={`hidden sm:flex absolute top-1/2 -translate-y-1/2 z-10 h-12 w-12 items-center justify-center rounded-full bg-white shadow-lg hover:bg-gray-50 transition-all duration-200 border border-gray-200 ${
                                isRTL ? '-right-6' : '-left-6'
                            }`}
                            aria-label={isRTL ? t('common.next') : t('common.previous')}
                        >
                            {isRTL ? (
                                <ChevronRight className="h-6 w-6 text-gray-600" />
                            ) : (
                                <ChevronLeft className="h-6 w-6 text-gray-600" />
                            )}
                        </button>
                        
                        <button
                            onClick={isRTL ? goToPrevSlide : goToNextSlide}
                            className={`hidden sm:flex absolute top-1/2 -translate-y-1/2 z-10 h-12 w-12 items-center justify-center rounded-full bg-white shadow-lg hover:bg-gray-50 transition-all duration-200 border border-gray-200 ${
                                isRTL ? '-left-6' : '-right-6'
                            }`}
                            aria-label={isRTL ? t('common.previous') : t('common.next')}
                        >
                            {isRTL ? (
                                <ChevronLeft className="h-6 w-6 text-gray-600" />
                            ) : (
                                <ChevronRight className="h-6 w-6 text-gray-600" />
                            )}
                        </button>
                    </>
                )}

                {/* Mobile Navigation Arrows - Below the card */}
                {filteredUrgentNews.length > 1 && (
                    <div className="sm:hidden flex justify-between gap-4 mt-6">
                        <button
                            onClick={isRTL ? goToNextSlide : goToPrevSlide}
                            className="flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-lg hover:bg-gray-50 transition-all duration-200 border border-gray-200"
                            aria-label={isRTL ? t('common.next') : t('common.previous')}
                        >
                            {isRTL ? (
                                <ChevronRight className="h-6 w-6 text-gray-600" />
                            ) : (
                                <ChevronLeft className="h-6 w-6 text-gray-600" />
                            )}
                        </button>
                        
                        <button
                            onClick={isRTL ? goToPrevSlide : goToNextSlide}
                            className="flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-lg hover:bg-gray-50 transition-all duration-200 border border-gray-200"
                            aria-label={isRTL ? t('common.previous') : t('common.next')}
                        >
                            {isRTL ? (
                                <ChevronLeft className="h-6 w-6 text-gray-600" />
                            ) : (
                                <ChevronRight className="h-6 w-6 text-gray-600" />
                            )}
                        </button>
                    </div>
                )}
            </div>
        </div>
    );
}