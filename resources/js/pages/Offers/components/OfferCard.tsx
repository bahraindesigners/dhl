import React from 'react';
import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { Tag, Building2, Percent } from 'lucide-react';
import { type Offer } from '@/types';

interface OfferCardProps {
    offer: Offer;
}

export default function OfferCard({ offer }: OfferCardProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    return (
        <div className="group relative bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-primary/20 hover:-translate-y-1 overflow-hidden">
            {/* Discount Badge */}
            <div className="absolute top-4 right-4 z-10">
                <div className="bg-gradient-to-r from-primary to-primary/80 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                    <Percent className="h-3 w-3" />
                    {offer.discount}
                </div>
            </div>

            {/* Card Content */}
            <div className="p-6">
                {/* Company */}
                <div className={`flex items-center gap-2 mb-3 ${isRTL ? 'flex-row-reverse' : ''}`}>
                    <Building2 className="h-4 w-4 text-primary" />
                    <span className={`text-sm text-primary font-medium ${isRTL ? 'font-arabic' : ''}`}>
                        {typeof offer.company_name === 'string' ? offer.company_name : 'Unknown Company'}
                    </span>
                </div>

                {/* Title */}
                <h3 className={`text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                    {typeof offer.title === 'string' ? offer.title : 'Untitled Offer'}
                </h3>

                {/* Description */}
                <p className={`text-gray-600 mb-4 line-clamp-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                    {typeof offer.description === 'string' ? offer.description : ''}
                </p>

                {/* Action */}
                <div className={`flex justify-between items-center ${isRTL ? 'flex-row-reverse' : ''}`}>
                    <Link
                        href={`/offers/${offer.id}`}
                        className={`
                            inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg 
                            hover:bg-primary/90 transition-colors duration-200 text-sm font-medium
                            ${isRTL ? 'flex-row-reverse font-arabic' : ''}
                        `}
                    >
                        <Tag className="h-4 w-4" />
                        {t('offers.viewOffer')}
                    </Link>

                    <time className={`text-xs text-gray-500 ${isRTL ? 'font-arabic' : ''}`}>
                        {new Date(offer.created_at).toLocaleDateString(i18n.language === 'ar' ? 'ar-BH' : 'en-US')}
                    </time>
                </div>
            </div>

            {/* Hover Effect */}
            <div className="absolute inset-0 bg-gradient-to-t from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
        </div>
    );
}