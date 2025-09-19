import { useTranslation } from "react-i18next";

export default function OurFoundations() {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';
    return (
         <div className="mt-16 space-y-16">
            {/* Section Header */}
            <div className="text-start mb-12">
                <h2 className={`text-3xl font-bold text-foreground mb-4 ${isRTL ? 'font-arabic' : ''}`}>{t('home.ourFoundation')}</h2>
                <p className={`text-muted-foreground  mx-auto ${isRTL ? 'font-arabic' : ''}`}>{t('home.foundationDescription')}</p>
            </div>

            {/* Vision & Mission - Side by Side */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {/* Vision */}
                <div className={`group relative overflow-hidden rounded-lg border border-border bg-white p-8 transition-all duration-300 hover:shadow-lg hover:border-primary/30 hover:-translate-y-1 ${isRTL ? 'text-right' : 'text-left'}`}>
                    <div className="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-primary/10 opacity-0 transition-opacity duration-300 group-hover:opacity-100" />
                    <div className="relative z-10">
                        <div className={`flex items-center mb-6 `}>
                            <div className="flex h-16 w-16 items-center justify-center rounded-xl bg-primary text-white">
                                <svg className="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h3 className={`${isRTL ? 'font-arabic' : ''} ms-4 text-2xl font-bold text-foreground group-hover:text-primary transition-colors duration-300`}>{t('home.vision')}</h3>
                        </div>
                        <p className={`text-base text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>{t('home.visionText')}</p>
                    </div>
                </div>

                {/* Mission */}
                <div className={`group relative overflow-hidden rounded-lg border border-border bg-white p-8 transition-all duration-300 hover:shadow-lg hover:border-primary/30 hover:-translate-y-1 ${isRTL ? 'text-right' : 'text-left'}`}>
                    <div className="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-primary/10 opacity-0 transition-opacity duration-300 group-hover:opacity-100" />
                    <div className="relative z-10">
                        <div className={`flex items-center mb-6 `}>
                            <div className="flex h-16 w-16 items-center justify-center rounded-xl bg-primary text-white">
                                <svg className="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 className={`${isRTL ? 'font-arabic' : ''} ms-4 text-2xl font-bold text-foreground group-hover:text-primary transition-colors duration-300`}>{t('home.mission')}</h3>
                        </div>
                        <p className={`text-base text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>{t('home.missionText')}</p>
                    </div>
                </div>
            </div>

            {/* Objectives - Separate Section */}
            <div className="mt-18">
                <div className={`flex items-center justify-start mb-6 `}>
                    <div className="flex h-16 w-16 items-center justify-center rounded-xl bg-primary text-white">
                        <svg className="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m6 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 className={`${isRTL ? 'font-arabic' : ''} ms-4 text-2xl font-bold text-foreground group-hover:text-primary transition-colors duration-300`}>{t('home.objectives')}</h3>
                </div>

                {/* Objectives Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {/* Objective 1 */}
                    <div className={`group bg-white rounded-lg border border-border p-6 transition-all duration-300 hover:shadow-md hover:border-primary/30 hover:-translate-y-0.5 ${isRTL ? 'text-right' : 'text-left'}`}>
                        <div className={`flex items-start gap-4 `}>
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary flex-shrink-0">
                                <span className="text-sm font-bold">1</span>
                            </div>
                            <p className={`text-sm text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>{t('home.objective1')}</p>
                        </div>
                    </div>

                    {/* Objective 2 */}
                    <div className={`group bg-white rounded-lg border border-border p-6 transition-all duration-300 hover:shadow-md hover:border-primary/30 hover:-translate-y-0.5 ${isRTL ? 'text-right' : 'text-left'}`}>
                        <div className={`flex items-start gap-4 `}>
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary flex-shrink-0">
                                <span className="text-sm font-bold">2</span>
                            </div>
                            <p className={`text-sm text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>{t('home.objective2')}</p>
                        </div>
                    </div>

                    {/* Objective 3 */}
                    <div className={`group bg-white rounded-lg border border-border p-6 transition-all duration-300 hover:shadow-md hover:border-primary/30 hover:-translate-y-0.5 ${isRTL ? 'text-right' : 'text-left'}`}>
                        <div className={`flex items-start gap-4 `}>
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary flex-shrink-0">
                                <span className="text-sm font-bold">3</span>
                            </div>
                            <p className={`text-sm text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>{t('home.objective3')}</p>
                        </div>
                    </div>

                    {/* Objective 4 */}
                    <div className={`group bg-white rounded-lg border border-border p-6 transition-all duration-300 hover:shadow-md hover:border-primary/30 hover:-translate-y-0.5 ${isRTL ? 'text-right' : 'text-left'}`}>
                        <div className={`flex items-start gap-4 `}>
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary flex-shrink-0">
                                <span className="text-sm font-bold">4</span>
                            </div>
                            <p className={`text-sm text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>{t('home.objective4')}</p>
                        </div>
                    </div>

                    {/* Objective 5 */}
                    <div className={`group bg-white rounded-lg border border-border p-6 transition-all duration-300 hover:shadow-md hover:border-primary/30 hover:-translate-y-0.5 ${isRTL ? 'text-right' : 'text-left'}`}>
                        <div className={`flex items-start gap-4 `}>
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary flex-shrink-0">
                                <span className="text-sm font-bold">5</span>
                            </div>
                            <p className={`text-sm text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>{t('home.objective5')}</p>
                        </div>
                    </div>

                    {/* Objective 6 */}
                    <div className={`group bg-white rounded-lg border border-border p-6 transition-all duration-300 hover:shadow-md hover:border-primary/30 hover:-translate-y-0.5 ${isRTL ? 'text-right' : 'text-left'}`}>
                        <div className={`flex items-start gap-4 `}>
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary flex-shrink-0">
                                <span className="text-sm font-bold">6</span>
                            </div>
                            <p className={`text-sm text-muted-foreground leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>{t('home.objective6')}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}