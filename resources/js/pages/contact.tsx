import NavbarLayout from '@/layouts/navbar-layout';
import { Head, Form } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { 
    MessageCircle, 
    MapPin, 
    Phone, 
    Clock, 
    Instagram, 
    Linkedin, 
    Mail,
    Send
} from 'lucide-react';

interface ContactSettings {
    is_active: boolean;
    instagram_url?: string;
    linkedin_url?: string;
    x_url?: string;
    office_address?: { en: string; ar: string };
    phone_numbers?: { en: string; ar: string };
    office_hours?: { en: string; ar: string };
    content?: { en: string; ar: string };
}

interface ContactProps {
    settings: ContactSettings;
}

export default function Contact({ settings }: ContactProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // Helper function to check if a translatable field has content
    const hasContent = (field?: { en: string; ar: string }): boolean => {
        if (!field) return false;
        const content = (field as any)[i18n.language] || field.en || field.ar;
        return content && content.trim() !== '' && content !== '<p></p>';
    };

    return (
        <NavbarLayout>
            <Head title={t('nav.contact')} />

            {/* Hero Section - Matching News Page Style */}
            <section className={`relative bg-gradient-to-br from-primary/5 via-white to-primary/10 py-8 sm:py-12 ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-from)_0%,_transparent_50%)] from-primary/20"></div>
                
                <div className="relative w-full px-4 sm:px-6 lg:px-8">
                    <div className="w-full">
                        {/* Animated Icon */}
                        <div className="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/20 to-primary/10 backdrop-blur-sm">
                            <MessageCircle className="h-7 w-7 text-primary" />
                        </div>

                        {/* Title */}
                        <h1 className={`text-center text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl ${isRTL ? 'font-arabic' : ''}`}>
                            {t('nav.contact')}
                        </h1>
                        <p className={`mx-auto mt-3 max-w-2xl text-center text-base leading-7 text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('contact.description')}
                        </p>
                    </div>
                </div>
            </section>

            {/* Main Content */}
            <section className="py-16">
                <div className={`mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Contact Form */}
                        <div className="lg:col-span-2">
                            <div className="bg-white rounded-xl border border-gray-100 overflow-hidden">
                                <div className="p-8">
                                    <h2 className={`text-2xl font-semibold text-gray-900 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                        {t('contact.sendMessage')}
                                    </h2>
                                    <p className={`text-gray-600 mb-8 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                        {t('contact.formDescription')}
                                    </p>

                                    {/* Form Disabled Message */}
                                    {!settings.is_active && (
                                        <div className="p-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
                                            <div className="flex items-start">
                                                <div className="flex-shrink-0">
                                                    <svg className="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fillRule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clipRule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div className={`${isRTL ? 'mr-3' : 'ml-3'}`}>
                                                    <h3 className={`text-sm font-medium text-yellow-800 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                        {t('contact.formDisabledTitle')}
                                                    </h3>
                                                    <p className={`mt-2 text-sm text-yellow-700 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                        {t('contact.formDisabledMessage')}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    )}

                                    {/* Contact Form - Only show when active */}
                                    {settings.is_active && (
                                        <Form
                                            action="/contact"
                                            method="post"
                                            resetOnSuccess={true}
                                        >
                                            {({
                                                errors,
                                                hasErrors,
                                                processing,
                                                wasSuccessful,
                                                recentlySuccessful
                                            }) => (
                                            <>
                                                {recentlySuccessful && (
                                                    <div className="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-r-lg">
                                                        <p className={`text-green-800 ${isRTL ? 'font-arabic' : ''}`}>
                                                            {t('contact.successMessage')}
                                                        </p>
                                                    </div>
                                                )}

                                                {errors.general && (
                                                    <div className="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
                                                        <p className={`text-red-800 ${isRTL ? 'font-arabic' : ''}`}>
                                                            {errors.general}
                                                        </p>
                                                    </div>
                                                )}

                                                <div className="space-y-6">
                                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                        <div>
                                                            <label htmlFor="name" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                                {t('common.name')}
                                                            </label>
                                                            <input
                                                                type="text"
                                                                id="name"
                                                                name="name"
                                                                className={`w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all ${
                                                                    errors.name ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : ''
                                                                } ${isRTL ? 'text-right font-arabic' : 'text-left'}`}
                                                                placeholder={t('contact.namePlaceholder')}
                                                                dir={isRTL ? 'rtl' : 'ltr'}
                                                            />
                                                            {errors.name && (
                                                                <p className={`mt-2 text-sm text-red-600 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>{errors.name}</p>
                                                            )}
                                                        </div>

                                                        <div>
                                                            <label htmlFor="email" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                                {t('common.email')}
                                                            </label>
                                                            <input
                                                                type="email"
                                                                id="email"
                                                                name="email"
                                                                className={`w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all ${
                                                                    errors.email ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : ''
                                                                } ${isRTL ? 'text-right font-arabic' : 'text-left'}`}
                                                                placeholder={t('contact.emailPlaceholder')}
                                                                dir={isRTL ? 'rtl' : 'ltr'}
                                                            />
                                                            {errors.email && (
                                                                <p className={`mt-2 text-sm text-red-600 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>{errors.email}</p>
                                                            )}
                                                        </div>
                                                    </div>

                                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                        <div>
                                                            <label htmlFor="phone" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                                {t('common.phone')}
                                                            </label>
                                                            <input
                                                                type="tel"
                                                                id="phone"
                                                                name="phone"
                                                                className={`w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all ${
                                                                    errors.phone ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : ''
                                                                } ${isRTL ? 'text-right font-arabic' : 'text-left'}`}
                                                                placeholder={t('contact.phonePlaceholder')}
                                                                dir={isRTL ? 'rtl' : 'ltr'}
                                                            />
                                                            {errors.phone && (
                                                                <p className={`mt-2 text-sm text-red-600 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>{errors.phone}</p>
                                                            )}
                                                        </div>

                                                        <div>
                                                            <label htmlFor="subject" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                                {t('contact.subject')}
                                                            </label>
                                                            <input
                                                                type="text"
                                                                id="subject"
                                                                name="subject"
                                                                className={`w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all ${
                                                                    errors.subject ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : ''
                                                                } ${isRTL ? 'text-right font-arabic' : 'text-left'}`}
                                                                placeholder={t('contact.subjectPlaceholder')}
                                                                dir={isRTL ? 'rtl' : 'ltr'}
                                                            />
                                                            {errors.subject && (
                                                                <p className={`mt-2 text-sm text-red-600 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>{errors.subject}</p>
                                                            )}
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label htmlFor="message" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                            {t('contact.message')}
                                                        </label>
                                                        <textarea
                                                            id="message"
                                                            name="message"
                                                            rows={5}
                                                            className={`w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none ${
                                                                errors.message ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : ''
                                                            } ${isRTL ? 'text-right font-arabic' : 'text-left'}`}
                                                            placeholder={t('contact.messagePlaceholder')}
                                                            dir={isRTL ? 'rtl' : 'ltr'}
                                                        ></textarea>
                                                        {errors.message && (
                                                            <p className={`mt-2 text-sm text-red-600 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>{errors.message}</p>
                                                        )}
                                                    </div>

                                                    <button
                                                        type="submit"
                                                        disabled={processing}
                                                        className={`w-full bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:ring-offset-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed font-medium ${isRTL ? 'font-arabic' : ''}`}
                                                    >
                                                        <div className={`flex items-center justify-center ${isRTL ? 'space-x-reverse' : ''} space-x-2`}>
                                                            {!processing && <Send className="h-4 w-4" />}
                                                            <span>{processing ? t('contact.sending') : t('contact.sendMessage')}</span>
                                                        </div>
                                                    </button>
                                                </div>
                                            </>
                                        )}
                                    </Form>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Essential Contact Information */}
                        <div className="space-y-6">
                            {/* Office Address */}
                            {hasContent(settings?.office_address) && (
                                <div className="bg-white rounded-xl border border-gray-100 p-6">
                                    <div className={`flex items-start ${isRTL ? 'space-x-reverse' : ''} space-x-4`}>
                                        <div className="flex-shrink-0">
                                            <div className="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                                <MapPin className="h-5 w-5 text-primary" />
                                            </div>
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <h3 className={`text-lg font-semibold text-gray-900 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                {t('contact.officeAddress')}
                                            </h3>
                                            <div
                                                className={`prose prose-sm max-w-none text-gray-600 leading-relaxed ${isRTL ? 'prose-rtl [&>*]:text-right font-arabic' : ''}`}
                                                dangerouslySetInnerHTML={{
                                                    __html: settings.office_address ? ((settings.office_address as any)[i18n.language] || settings.office_address.en || settings.office_address.ar || '') : ''
                                                }}
                                            />
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Phone Numbers */}
                            {hasContent(settings?.phone_numbers) && (
                                <div className="bg-white rounded-xl border border-gray-100 p-6">
                                    <div className={`flex items-start ${isRTL ? 'space-x-reverse' : ''} space-x-4`}>
                                        <div className="flex-shrink-0">
                                            <div className="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                                <Phone className="h-5 w-5 text-primary" />
                                            </div>
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <h3 className={`text-lg font-semibold text-gray-900 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                {t('contact.phone')}
                                            </h3>
                                            <p className={`text-gray-600 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                {settings.phone_numbers ? ((settings.phone_numbers as any)[i18n.language] || settings.phone_numbers.en || settings.phone_numbers.ar) : ''}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Office Hours */}
                            {hasContent(settings?.office_hours) && (
                                <div className="bg-white rounded-xl border border-gray-100 p-6">
                                    <div className={`flex items-start ${isRTL ? 'space-x-reverse' : ''} space-x-4`}>
                                        <div className="flex-shrink-0">
                                            <div className="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                                <Clock className="h-5 w-5 text-primary" />
                                            </div>
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <h3 className={`text-lg font-semibold text-gray-900 mb-2 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                {t('contact.officeHours')}
                                            </h3>
                                            <div
                                                className={`prose prose-sm max-w-none text-gray-600 leading-relaxed ${isRTL ? 'prose-rtl [&>*]:text-right font-arabic' : ''}`}
                                                dangerouslySetInnerHTML={{
                                                    __html: settings.office_hours ? ((settings.office_hours as any)[i18n.language] || settings.office_hours.en || settings.office_hours.ar || '') : ''
                                                }}
                                            />
                                        </div>
                                    </div>
                                </div>
                            )}



                            {/* Social Media Links */}
                            {(settings?.instagram_url || settings?.linkedin_url || settings?.x_url) && (
                                <div className="bg-white rounded-xl border border-gray-100 p-6">
                                    <h3 className={`text-lg font-semibold text-gray-900 mb-4 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                        {t('contact.followUs')}
                                    </h3>
                                    <div className={`flex ${isRTL ? 'gap-x-reverse' : ''} gap-x-3`}>
                                        {settings?.instagram_url && (
                                            <a
                                                href={settings.instagram_url}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="inline-flex items-center justify-center w-10 h-10 text-gray-600 hover:text-gray-900 transition-colors duration-200"
                                                aria-label={t('contact.followInstagram')}
                                            >
                                                <Instagram className="h-5 w-5" />
                                            </a>
                                        )}
                                        {settings?.linkedin_url && (
                                            <a
                                                href={settings.linkedin_url}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="inline-flex items-center justify-center w-10 h-10 text-gray-600 hover:text-gray-900 transition-colors duration-200"
                                                aria-label={t('contact.followLinkedIn')}
                                            >
                                                <Linkedin className="h-5 w-5" />
                                            </a>
                                        )}
                                        {settings?.x_url && (
                                            <a
                                                href={settings.x_url}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="inline-flex items-center justify-center w-10 h-10 text-gray-600 hover:text-gray-900 transition-colors duration-200"
                                                aria-label={t('contact.followX')}
                                            >
                                                <svg className="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                                </svg>
                                            </a>
                                        )}
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </section>

            {/* Additional Information Section */}
            {hasContent(settings?.content) && (
                <section className="py-16 bg-gray-50/50">
                    <div className={`mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                        <div className="bg-white rounded-xl border border-gray-100 overflow-hidden">
                            <div className="p-8">
                                <div className={`flex items-center ${isRTL ? 'space-x-reverse' : ''} space-x-4 mb-6`}>
                                    <div className="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <Mail className="h-6 w-6 text-primary" />
                                    </div>
                                    <h2 className={`text-2xl font-semibold text-gray-900 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                        {t('contact.additionalInfo')}
                                    </h2>
                                </div>
                                <div
                                    className={`prose prose-lg max-w-none text-gray-600 leading-relaxed ${isRTL ? 'prose-rtl [&>*]:text-right font-arabic' : ''}`}
                                    dangerouslySetInnerHTML={{
                                        __html: settings.content ? ((settings.content as any)[i18n.language] || settings.content.en || settings.content.ar || '') : ''
                                    }}
                                />
                            </div>
                        </div>
                    </div>
                </section>
            )}
        </NavbarLayout>
    );
}