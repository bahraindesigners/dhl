import { dashboard, login, register } from '@/routes';
import { type SharedData, HomeSlider as SliderType } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import HomeSlider from '@/pages/Home/components/home-slider';
import NavbarLayout from '@/layouts/navbar-layout';
import HomeActionCard from './components/action-card';
import { useTranslation } from 'react-i18next';

interface WelcomeProps {
    sliders?: SliderType[];
}

export default function Welcome() {
    const { auth, sliders = [] } = usePage<SharedData & WelcomeProps>().props;
    const { t } = useTranslation();

    return (
        <NavbarLayout>
            <Head title={t('company.name')}>
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            
            {/* Main Content */}
            <main className="min-h-screen px-8 py-6">
                {/* Hero Slider Section */}
                {sliders.length > 0 && (
                    <section>
                        <HomeSlider sliders={sliders} />
                    </section>
                )}

                {/* Content Section */}
                <section className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-4">
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
                            title={t('home.offersAndDiscounts')}
                            description={t('home.offersAndDiscountsDescription')}
                            link={"/dashboard"}
                        />
                    </div>
                </section>
            </main>
        </NavbarLayout>
    );
}