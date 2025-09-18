import { dashboard, login, register } from '@/routes';
import { type SharedData, HomeSlider as SliderType } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import HomeSlider from '@/components/home-slider';

interface WelcomeProps {
    sliders?: SliderType[];
}

export default function Welcome() {
    const { auth, sliders = [] } = usePage<SharedData & WelcomeProps>().props;

    return (
        <>
            <Head title="DHL Bahraini Trade Union">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            
            {/* Navigation Header */}
            <header className="bg-white shadow-sm">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-between">
                        <div className="flex items-center">
                            <h1 className="text-xl font-bold text-red-600">DHL Bahraini Trade Union</h1>
                        </div>
                        <nav className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={dashboard()}
                                    className="inline-block rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={login()}
                                        className="text-sm font-medium text-gray-700 hover:text-red-600"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={register()}
                                        className="inline-block rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </nav>
                    </div>
                </div>
            </header>

            {/* Main Content */}
            <main className="min-h-screen  px-8 py-6 ">
                {/* Hero Slider Section */}
                {sliders.length > 0 && (
                    <section>
                        <HomeSlider sliders={sliders} />
                    </section>
                )}

                {/* Content Section */}
                <section className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                    
                </section>
            </main>
        </>
    );
}