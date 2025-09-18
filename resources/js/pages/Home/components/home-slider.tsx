import { HomeSlider as SliderType } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { useRef } from 'react';
import Slider from 'react-slick';
import { useTranslation } from 'react-i18next';

interface HomeSliderProps {
    sliders: SliderType[];
    autoPlay?: boolean;
    autoPlayInterval?: number;
}

export default function HomeSlider({
    sliders,
    autoPlay = true,
    autoPlayInterval = 5000
}: HomeSliderProps) {
    const sliderRef = useRef<Slider>(null);
    const { t, i18n } = useTranslation();
    const page = usePage();
    
    // Get current locale from backend for dynamic content
    const currentLocale = (page.props as any).locale || 'en';
    const isRTL = i18n.language === 'ar' || currentLocale === 'ar';
    
    // Helper function to get content - works with both old and new format
    const getContent = (content: string | Record<string, string>): string => {
        if (typeof content === 'string') {
            return content;
        }
        
        if (typeof content === 'object' && content !== null) {
            // Use current backend locale, fallback to English, then first available
            return content[currentLocale] || 
                   content['en'] || 
                   Object.values(content)[0] || 
                   '';
        }
        
        return '';
    };

    const goToPrevSlide = () => {
        sliderRef.current?.slickPrev();
    };

    const goToNextSlide = () => {
        sliderRef.current?.slickNext();
    };

    if (!sliders || sliders.length === 0) {
        return null;
    }

    const settings = {
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: autoPlay,
        autoplaySpeed: autoPlayInterval,
        arrows: false, // We'll use custom arrows
        dotsClass: 'slick-dots custom-dots',
        pauseOnHover: true,
        pauseOnDotsHover: true,
        fade: false, // Changed from fade to slide
        cssEase: 'ease-in-out',
        rtl: isRTL, // Enable RTL support for Arabic
    };

    return (
        <div className={`relative w-full h-[500px] ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
            {/* Container with arrows outside */}
            <div className="flex items-center gap-4">
                {/* Navigation Arrows - Responsive to RTL */}
                {sliders.length > 1 && (
                    <button
                        onClick={isRTL ? goToNextSlide : goToPrevSlide}
                        className="flex-shrink-0 hidden md:block rounded-full bg-white/80 backdrop-blur-sm p-2 text-gray-700 shadow-lg transition-all duration-200 hover:bg-white hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-primary/50 sm:p-3"
                        aria-label={isRTL ? t('slider.nextSlide') : t('slider.previousSlide')}
                    >
                        {isRTL ? (
                            <ChevronRight className="h-5 w-5 sm:h-6 sm:w-6" />
                        ) : (
                            <ChevronLeft className="h-5 w-5 sm:h-6 sm:w-6" />
                        )}
                    </button>
                )}

                {/* Slider Container */}
                <div className="relative flex-1 h-[500px] overflow-hidden rounded-lg">
                    <Slider ref={sliderRef} {...settings}>
                        {sliders.map((slider) => (
                            <div key={slider.id}>
                                {/* Split Layout Container - RTL Responsive */}
                                <div className={`flex h-[500px] flex-col lg:flex-row ${isRTL ? 'lg:flex-row-reverse' : ''}`}>
                                    {/* Content Section - Responsive to RTL */}
                                    <div className={`flex flex-1 items-center justify-center bg-gradient-to-br  px-6 py-10 sm:px-8 sm:py-12 md:px-12 lg:px-16 xl:px-20 ${isRTL ? 'lg:rounded-r-lg text-right' : 'lg:rounded-l-lg text-left'}`}>
                                        <div className="w-full max-w-xl lg:max-w-2xl">
                                            <h1 className={`mb-4 text-2xl font-bold text-gray-900 sm:mb-6 sm:text-3xl md:text-4xl lg:text-5xl ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                {getContent(slider.title)}
                                            </h1>
                                            
                                            {/* Subtitle */}
                                            {slider.subtitle && (
                                                <h2 className={`mb-4 text-lg font-semibold text-gray-700 sm:text-xl md:text-2xl ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                    {getContent(slider.subtitle)}
                                                </h2>
                                            )}
                                            
                                            {/* Description */}
                                            {slider.description && (
                                                <p className={`mb-6 text-base text-gray-600 sm:mb-8 sm:text-lg md:text-xl ${isRTL ? 'text-right leading-relaxed font-arabic' : 'text-left'}`}>
                                                    {getContent(slider.description)}
                                                </p>
                                            )}

                                            {/* Action Buttons */}
                                            {slider.button_text && slider.button_url && (
                                                <Link
                                                    href={slider.button_url}
                                                    className={`inline-flex items-center justify-center rounded-lg bg-primary px-6 py-3 text-base font-semibold text-primary-foreground shadow-lg transition-all duration-200 hover:bg-primary/90 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-primary/50 sm:px-8 sm:py-3 sm:text-lg ${isRTL ? 'font-arabic' : ''}`}
                                                >
                                                    {getContent(slider.button_text)}
                                                </Link>
                                            )}
                                        </div>
                                    </div>

                                    {/* Image Section - Right Side */}
                                    <div className="relative h-full flex-1 overflow-hidden rounded-lg lg:h-full">
                                        {(slider.desktop_image || slider.mobile_image) ? (
                                            <>
                                                <picture>
                                                    {slider.mobile_image && (
                                                        <source
                                                            media="(max-width: 768px)"
                                                            srcSet={slider.mobile_image}
                                                        />
                                                    )}
                                                    <img
                                                        src={slider.desktop_image || slider.mobile_image}
                                                        alt={getContent(slider.title)}
                                                        className="h-full w-full object-cover object-center"
                                                    />
                                                </picture>
                                            </>
                                        ) : (
                                            // Fallback content when no image is uploaded
                                            <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                                <div className="text-center px-4">
                                                    {/* DHL Logo Placeholder */}
                                                    <div className="mb-4 inline-flex h-16 w-32 items-center justify-center rounded-lg bg-primary sm:mb-6 sm:h-20 sm:w-40">
                                                        <span className="text-xl font-bold text-red-600 sm:text-2xl">DHL</span>
                                                    </div>
                                                    {/* Content Overlay */}
                                                    <div className="rounded-lg bg-white/90 p-4 shadow-lg backdrop-blur-sm sm:p-6">
                                                        <h3 className="mb-2 text-lg font-bold text-gray-900 sm:text-xl">
                                                            {t('company.tagline')}
                                                        </h3>
                                                        <p className="text-sm text-gray-600 sm:text-base">
                                                            {t('slider.fallbackDescription')}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        ))}
                    </Slider>
                </div>

                {/* Right Arrow - Responsive to RTL */}
                {sliders.length > 1 && (
                    <button
                        onClick={isRTL ? goToPrevSlide : goToNextSlide}
                        className="flex-shrink-0 hidden md:block rounded-full bg-white/80 backdrop-blur-sm p-2 text-gray-700 shadow-lg transition-all duration-200 hover:bg-white hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-primary/50 sm:p-3"
                        aria-label={isRTL ? t('slider.previousSlide') : t('slider.nextSlide')}
                    >
                        {isRTL ? (
                            <ChevronLeft className="h-5 w-5 sm:h-6 sm:w-6" />
                        ) : (
                            <ChevronRight className="h-5 w-5 sm:h-6 sm:w-6" />
                        )}
                    </button>
                )}
            </div>
        </div>
    );
}