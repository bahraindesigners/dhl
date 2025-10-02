import { Link, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import {
    Mail,
    Phone,
    MapPin,
    Facebook,
    Twitter,
    Instagram,
    Linkedin,
    ArrowUp
} from 'lucide-react';
import { Button } from '@/components/ui/button';
import { useLanguageDirection } from '@/hooks/use-language-direction';

interface ContactSettings {
    instagram_url: string | null;
    linkedin_url: string | null;
    x_url: string | null;
    office_address: Record<string, string>;
    phone_numbers: Record<string, string>;
}

interface PageProps extends Record<string, any> {
    contactSettings: ContactSettings;
}

export function Footer() {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';
    const { props } = usePage<PageProps>();
    const { contactSettings } = props;

    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    const currentYear = new Date().getFullYear();

    // Get localized contact information
    const currentLang = i18n.language;
    const officeAddress = contactSettings.office_address[currentLang] || contactSettings.office_address['en'];
    const phoneNumbers = contactSettings.phone_numbers[currentLang] || contactSettings.phone_numbers['en'];

    return (
        <footer className="bg-gray-600 text-white">
            {/* Main Footer Content */}
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div className="grid grid-cols-1 md:grid-cols-2  gap-8">
                    {/* Company Info */}
                    <div className="space-y-4">
                        <h3 className={`text-lg font-bold ${isRTL ? 'font-arabic' : ''}`}>
                            {t('company.name')}
                        </h3>
                        <p className={`text-gray-300 text-sm leading-relaxed ${isRTL ? 'font-arabic' : ''}`}>
                            {t('footer.companyDescription')}
                        </p>
                        <div className="flex space-x-4">
                            {contactSettings.instagram_url && (
                                <a
                                    href={contactSettings.instagram_url}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-gray-400 hover:text-primary transition-colors"
                                    aria-label="Instagram"
                                >
                                    <Instagram className="h-5 w-5" />
                                </a>
                            )}
                            {contactSettings.x_url && (
                                <a
                                    href={contactSettings.x_url}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-gray-400 hover:text-primary transition-colors"
                                    aria-label="X (Twitter)"
                                >
                                    <Twitter className="h-5 w-5" />
                                </a>
                            )}
                            {contactSettings.linkedin_url && (
                                <a
                                    href={contactSettings.linkedin_url}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-gray-400 hover:text-primary transition-colors"
                                    aria-label="LinkedIn"
                                >
                                    <Linkedin className="h-5 w-5" />
                                </a>
                            )}
                        </div>
                    </div>

                    {/* Contact Info */}
                    <div className="space-y-4">
                        <h3 className={`text-lg font-bold ${isRTL ? 'font-arabic' : ''}`}>
                            {t('footer.contactInfo')}
                        </h3>
                        <div className="space-y-3">
                            {phoneNumbers && (
                                <div className="flex items-center space-x-3">
                                    <Phone className="h-4 w-4 text-primary flex-shrink-0" />
                                    <span className="text-gray-300 text-sm" dir='ltr'>
                                        {phoneNumbers}
                                    </span>
                                </div>
                            )}
                            {officeAddress && (
                                <div className="flex items-start space-x-3">
                                    <MapPin className="h-4 w-4 text-primary flex-shrink-0 mt-0.5" />
                                    <address
                                        className={`text-gray-300 text-sm not-italic leading-relaxed ${isRTL ? 'font-arabic' : ''}`}
                                        dangerouslySetInnerHTML={{ __html: officeAddress }}
                                    />
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>

            {/* Bottom Bar */}
            <div className="border-t border-gray-800">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <p className={`text-gray-400 text-center text-sm ${isRTL ? 'font-arabic' : ''}`}>
                        © {currentYear} {t('company.name')}. {t('footer.allRightsReserved')}
                    </p>
                </div>
            </div>
        </footer>
    );
}