import { useTranslation } from 'react-i18next';
import { useLanguageDirection } from '@/hooks/use-language-direction';

export default function HomeActionCard({
    title,
    description,
    link,
    linkText,
}: {
    title: string;
    description: string;
    link: string;
    linkText?: string;
}) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';
    
    const defaultLinkText = linkText || t('home.learnMore');
    return (
        <div className={`group relative overflow-hidden rounded-lg border border-border/70 bg-card/50 p-4 backdrop-blur-sm transition-all duration-300 hover:border-primary/20 hover:bg-card hover:shadow-lg hover:shadow-primary/5 hover:-translate-y-0.5 ${isRTL ? 'text-right' : 'text-left'}`} dir={isRTL ? 'rtl' : 'ltr'}>
            {/* Background gradient overlay */}
            <div className="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-accent/5 opacity-0 transition-opacity duration-300 group-hover:opacity-100" />
            
            {/* Content */}
            <div className="relative z-10">
                <h2 className={`mb-2 text-lg font-semibold text-foreground group-hover:text-primary transition-colors duration-300 ${isRTL ? 'font-arabic' : ''}`}>
                    {title}
                </h2>
                <p className={`mb-3 text-xs text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>
                    {description}
                </p>
                <a
                    href={link}
                    className={`inline-flex items-center gap-1.5 text-xs font-medium text-primary hover:text-primary/80 transition-colors duration-200 group/link ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}
                >
                    <span>{defaultLinkText}</span>
                    <svg 
                        className={`h-3 w-3 transition-transform duration-200 group-hover/link:${isRTL ? '-translate-x-0.5' : 'translate-x-0.5'}`}
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor"
                    >
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d={isRTL ? "M15 19l-7-7 7-7" : "M9 5l7 7-7 7"} />
                    </svg>
                </a>
            </div>
        </div>
    );
}