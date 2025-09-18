import { dashboard, login, register } from '@/routes';
import { type SharedData, HomeSlider as SliderType } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import HomeSlider from '@/components/home-slider';
import NavbarLayout from '@/layouts/navbar-layout';

interface WelcomeProps {
    sliders?: SliderType[];
}

export default function Welcome() {
    const { auth, sliders = [] } = usePage<SharedData & WelcomeProps>().props;

    return (
        <NavbarLayout>
            <Head title="DHL Bahraini Trade Union">
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
                    {auth.user ? (
                        <div className="text-center">
                            <h2 className="text-2xl font-bold text-foreground mb-4">Welcome back!</h2>
                            <Link
                                href={dashboard()}
                                className="inline-block rounded-lg bg-primary px-6 py-3 text-sm font-medium text-primary-foreground hover:bg-primary/90"
                            >
                                Go to Dashboard
                            </Link>
                        </div>
                    ) : (
                        <div className="text-center">
                            <h2 className="text-2xl font-bold text-foreground mb-4">Join DHL Bahraini Trade Union</h2>
                            <div className="flex gap-4 justify-center">
                                <Link
                                    href={login()}
                                    className="inline-block rounded-lg border border-input px-6 py-3 text-sm font-medium hover:bg-accent hover:text-accent-foreground"
                                >
                                    Log in
                                </Link>
                                <Link
                                    href={register()}
                                    className="inline-block rounded-lg bg-primary px-6 py-3 text-sm font-medium text-primary-foreground hover:bg-primary/90"
                                >
                                    Register
                                </Link>
                            </div>
                        </div>
                    )}
                </section>
            </main>
        </NavbarLayout>
    );
}