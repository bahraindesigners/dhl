import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { ArrowLeft, ArrowRight, Building2, Tag, Calendar, Percent } from 'lucide-react';
import NavbarLayout from '@/layouts/navbar-layout';
import { type SharedData, type Offer } from '@/types';

interface OfferShowProps {
    offer: Offer;
}

export default function OfferShow() {
    const { offer } = usePage<SharedData & OfferShowProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    return (
        <NavbarLayout>
            <Head title={`${typeof offer.title === 'string' ? offer.title : 'Offer'} - ${t('company.name')}`} />
            
            {/* Hero Section */}
            <section className={`relative bg-gradient-to-br from-primary/5 via-white to-primary/10 py-16 ${isRTL ? 'rtl' : ''}`}>
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-from)_0%,_transparent_50%)] from-primary/20"></div>
                
                <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Back Button */}
                    <div className="mb-8">
                        <Link
                            href="/offers"
                            className={`inline-flex items-center gap-2 text-gray-600 hover:text-primary transition-colors duration-200 ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}
                        >
                            {isRTL ? <ArrowRight className="h-4 w-4" /> : <ArrowLeft className="h-4 w-4" />}
                            {t('offers.backToOffers')}
                        </Link>
                    </div>

                    {/* Offer Header */}
                    <div className={`text-center ${isRTL ? 'font-arabic' : ''}`}>
                        {/* Company Badge */}
                        <div className="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200 mb-6">
                            <Building2 className="h-4 w-4 text-primary" />
                            <span className="text-sm font-medium text-primary">
                                {typeof offer.company_name === 'string' ? offer.company_name : 'Unknown Company'}
                            </span>
                        </div>

                        {/* Title */}
                        <h1 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                            {typeof offer.title === 'string' ? offer.title : 'Untitled Offer'}
                        </h1>

                        {/* Description */}
                        <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                            {typeof offer.description === 'string' ? offer.description : ''}
                        </p>

                        {/* Discount Badge */}
                        <div className="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary/80 text-white rounded-full text-lg font-bold shadow-lg">
                            {/* <Percent className="h-5 w-5" /> */}
                            {offer.discount || 'N/A'}
                            {/* <span className="text-sm font-medium opacity-90">{t('offers.discountLabel')}</span> */}
                        </div>
                    </div>
                </div>
            </section>

            {/* Main Content */}
            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    {/* Offer Details Header */}
                    <div className="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 className={`text-lg font-semibold text-gray-900 ${isRTL ? 'font-arabic text-right' : ''}`}>
                            {t('offers.offerDetails')}
                        </h2>
                    </div>

                    {/* Offer Content */}
                    <div className="p-6">
                        {/* Meta Information */}
                        <div className={`flex flex-wrap gap-6 md:gap-12 mb-8 pb-6 border-b border-gray-200 `}>
                            <div className={`flex items-start gap-2 `}>
                                <Building2 className="h-5 w-5 text-gray-400" />
                                <div className={isRTL ? 'text-right' : ''}>
                                    <p className="text-sm text-gray-500">{t('offers.companyLabel')}</p>
                                    <p className={`font-medium text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                        {typeof offer.company_name === 'string' ? offer.company_name : 'Unknown Company'}
                                    </p>
                                </div>
                            </div>

                            <div className={`flex items-start gap-2 `}>
                                <Tag className="h-5 w-5 text-gray-400" />
                                <div className={isRTL ? 'text-right' : ''}>
                                    <p className="text-sm text-gray-500">{t('offers.discountLabel')}</p>
                                    <p className="font-medium text-gray-900">{offer.discount || 'N/A'}</p>
                                </div>
                            </div>

                            <div className={`flex items-start gap-2 `}>
                                <Calendar className="h-5 w-5 text-gray-400" />
                                <div className={isRTL ? 'text-right' : ''}>
                                    <p className="text-sm text-gray-500">Published</p>
                                    <p className={`font-medium text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                        {new Date(offer.created_at).toLocaleDateString(i18n.language === 'ar' ? 'ar-BH' : 'en-US', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric'
                                        })}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Offer Description */}
                        <div className={`prose prose-lg max-w-none ${isRTL ? 'font-arabic' : ''}`}>
                            <div 
                                className={`
                                    prose prose-lg prose-gray prose-content max-w-none
                                    prose-headings:text-gray-900 prose-headings:font-bold
                                    prose-h1:text-3xl prose-h1:mb-6 prose-h1:mt-8
                                    prose-h2:text-2xl prose-h2:mb-4 prose-h2:mt-6 prose-h2:text-primary
                                    prose-h3:text-xl prose-h3:mb-3 prose-h3:mt-5 prose-h3:text-gray-800
                                    prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-4
                                    prose-ul:my-4 prose-ul:space-y-2
                                    prose-ol:my-4 prose-ol:space-y-2
                                    prose-li:text-gray-600 prose-li:leading-relaxed
                                    prose-strong:text-gray-900 prose-strong:font-semibold
                                    prose-em:text-gray-700 prose-em:italic
                                    prose-blockquote:border-l-4 prose-blockquote:border-primary prose-blockquote:pl-4 prose-blockquote:italic prose-blockquote:text-gray-700
                                    prose-a:text-primary prose-a:no-underline hover:prose-a:underline
                                    prose-hr:my-8 prose-hr:border-gray-300
                                    [&>*]:text-left [&>*.text-center]:text-center [&>*.text-right]:text-right [&>*.text-justify]:text-justify
                                    ${isRTL ? '[&>*]:text-right [&>*.text-left]:text-left [&>*.text-center]:text-center [&>*.text-justify]:text-justify' : ''}
                                `}
                                dangerouslySetInnerHTML={{ 
                                    __html: typeof offer.offer_description === 'string' 
                                        ? offer.offer_description 
                                        : t('offers.noDescriptionAvailable')
                                }}
                            />
                        </div>
                    </div>
                </div>

                {/* Back to Offers Button */}
                <div className="mt-8 text-center">
                    <Link
                        href="/offers"
                        className={`inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors duration-200 ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}
                    >
                        {!isRTL ? <ArrowRight className="h-5 w-5" /> : <ArrowLeft className="h-5 w-5" />}
                        {t('offers.backToOffers')}
                    </Link>
                </div>
            </div>
        </NavbarLayout>
    );
}