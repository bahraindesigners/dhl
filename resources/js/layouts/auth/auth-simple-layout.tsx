import { home } from '@/routes';
import { Link } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';
import { useTranslation } from 'react-i18next';

interface AuthLayoutProps {
    name?: string;
    title?: string;
    description?: string;
}

export default function AuthSimpleLayout({ children, title, description }: PropsWithChildren<AuthLayoutProps>) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    return (
        <div className={`min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center p-4 ${isRTL ? 'rtl' : 'ltr'}`}>
            <div className="w-full max-w-md">
                <div className="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    {/* Header with Logo and Title */}
                    <div className="bg-gradient-to-r from-primary to-primary/90 px-8 py-8 text-center">
                        <Link href={home()} className="inline-block mb-4">
                            <img 
                                src="/uinuon-logo.jpeg" 
                                alt="DHL Union Logo"
                                className="h-16 w-16 rounded-full mx-auto shadow-lg border-2 border-white"
                            />
                        </Link>
                        <h1 className="text-2xl font-bold text-primary-foreground mb-2">{title}</h1>
                        <p className="text-primary-foreground/80 text-sm">{description}</p>
                    </div>

                    {/* Form Content */}
                    <div className="px-8 py-8">
                        {children}
                    </div>

                    {/* Footer */}
                    <div className="bg-gray-50 px-8 py-4 border-t border-gray-200">
                        <p className="text-center text-xs text-gray-600">
                            {t('auth.unionPortalFooter')}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}
