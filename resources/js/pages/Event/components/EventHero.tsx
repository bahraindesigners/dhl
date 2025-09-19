import { useTranslation } from 'react-i18next';
import { Calendar } from 'lucide-react';

export default function EventHero() {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    return (
        <section className={`relative bg-gradient-to-br from-primary/5 via-white to-primary/10 py-8 sm:py-12 ${isRTL ? 'rtl' : ''}`}>
            <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-from)_0%,_transparent_50%)] from-primary/20"></div>
            
            <div className="relative w-full px-4 sm:px-6 lg:px-8">
                <div className="w-full">
                    {/* Animated Icon */}
                    <div className="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/20 to-primary/10 backdrop-blur-sm">
                        <Calendar className="h-7 w-7 text-primary" />
                    </div>

                    {/* Title */}
                    <h1 className={`text-center text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl ${isRTL ? 'font-arabic' : ''}`}>
                        {t('events.pageTitle') || 'Events'}
                    </h1>
                    <p className={`mx-auto mt-3 max-w-2xl text-center text-base leading-7 text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                        {t('events.pageDescription') || 'Discover upcoming events, workshops, and activities organized by our community.'}
                    </p>
                </div>
            </div>
        </section>
    );
}