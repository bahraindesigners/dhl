import { useTranslation } from "react-i18next";
import HomeActionCard from "./action-card";
import { usePage } from '@inertiajs/react';
import { type SharedData } from '@/types';
export default function ActionCardsSection() {
    const { t } = useTranslation();
    const { auth } = usePage<SharedData>().props;
    const isRTL = t('direction') === 'rtl';
    return (
        <div className="mt-20">
            {/* Section Header */}
            <div className="text-start mb-12">
                <h2 className={`text-3xl font-bold text-foreground mb-4 ${isRTL ? 'font-arabic' : ''}`}>{t('home.actionCards')}</h2>
            </div>



            <div className="grid grid-cols-2 gap-6 md:grid-cols-3">
                <HomeActionCard
                    title={t('home.aboutUs')}
                    description={t('home.aboutUsDescription')}
                    link={"/about"}
                />
                <HomeActionCard
                    title={t('home.events')}
                    description={t('home.eventsDescription')}
                    link={"/events"}
                />
                <HomeActionCard
                    title={t('home.downloadResources')}
                    description={t('home.downloadResourcesDescription')}
                    link={"/dashboard"}
                />
                {
                    auth.user && (
                        <>
                            <HomeActionCard
                                title={t('home.membersServices')}
                                description={t('home.membersServicesDescription')}
                                link={"/about"}
                            />
                            <HomeActionCard
                                title={t('home.complaints')}
                                description={t('home.complaintsDescription')}
                                link={"/events"}
                            />
                            <HomeActionCard
                                title={t('home.offersAndDiscounts')}
                                description={t('home.offersAndDiscountsDescription')}
                                link={"/dashboard"}
                            />
                        </>
                    )
                }
            </div>
        </div>
    )
}