import { login, register } from '@/routes';
import { type SharedData, HomeSlider as SliderType, Blog, Event } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import HomeSlider from '@/pages/Home/components/home-slider';
import NavbarLayout from '@/layouts/navbar-layout';
import HomeActionCard from './components/action-card';
import { useTranslation } from 'react-i18next';
import OurFoundations from './components/our-foundations';
import ActionCardsSection from './components/action-cards-section';
import LatestNews from './components/latest-news';
import LatestEvents from './components/latest-events';

interface WelcomeProps {
    sliders?: SliderType[];
    news?: Blog[];
    events?: Event[];
}

export default function Welcome() {
    const { auth, sliders = [], news = [], events = [] } = usePage<SharedData & WelcomeProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

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

                    {/* Vision, Mission & Objectives Section */}
                    <OurFoundations />

                    {/* Latest News Section */}
                    <LatestNews news={news} />

                    {/* Action Cards */}
                    <ActionCardsSection />
                </section>

                {/* Latest Events Section */}
                <LatestEvents events={events} />
                
            </main>
        </NavbarLayout>
    );
}