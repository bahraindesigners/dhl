import React, { useState, useMemo } from 'react';
import { Head, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { Gift, Search, Filter, X } from 'lucide-react';
import NavbarLayout from '@/layouts/navbar-layout';
import OfferCard from './components/OfferCard';
import { type SharedData, type Offer } from '@/types';

interface OffersPageProps {
    offers: Offer[];
}

export default function OffersIndex() {
    const { offers } = usePage<SharedData & OffersPageProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // Filter and search states
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedCompany, setSelectedCompany] = useState('');
    const [sortBy, setSortBy] = useState('newest');

    // Get unique companies for filter
    const companies = useMemo(() => {
        const companySet = new Set<string>();
        offers.forEach(offer => {
            // Since Laravel resolves translations on backend, we can treat as string
            const companyName = typeof offer.company_name === 'string' ? offer.company_name : '';
            if (companyName.trim()) {
                companySet.add(companyName);
            }
        });
        return Array.from(companySet).sort();
    }, [offers]);

    // Filter and sort offers
    const filteredOffers = useMemo(() => {
        return offers.filter(offer => {
            // Search filter
            if (searchTerm) {
                const query = searchTerm.toLowerCase();
                const title = (typeof offer.title === 'string' ? offer.title : '').toLowerCase();
                const description = (typeof offer.description === 'string' ? offer.description : '').toLowerCase();
                const companyName = (typeof offer.company_name === 'string' ? offer.company_name : '').toLowerCase();
                
                if (!title.includes(query) && !description.includes(query) && !companyName.includes(query)) {
                    return false;
                }
            }

            // Company filter
            if (selectedCompany && selectedCompany !== 'all') {
                const companyName = typeof offer.company_name === 'string' ? offer.company_name : '';
                if (companyName !== selectedCompany) {
                    return false;
                }
            }

            return true;
        });
    }, [offers, searchTerm, selectedCompany]);

    const sortedOffers = useMemo(() => {
        return [...filteredOffers].sort((a, b) => {
            switch (sortBy) {
                case 'title':
                    const titleA = typeof a.title === 'string' ? a.title : '';
                    const titleB = typeof b.title === 'string' ? b.title : '';
                    return titleA.localeCompare(titleB);
                case 'company':
                    const companyA = typeof a.company_name === 'string' ? a.company_name : '';
                    const companyB = typeof b.company_name === 'string' ? b.company_name : '';
                    return companyA.localeCompare(companyB);
                case 'newest':
                    return new Date(b.created_at).getTime() - new Date(a.created_at).getTime();
                case 'oldest':
                    return new Date(a.created_at).getTime() - new Date(b.created_at).getTime();
                default:
                    return 0;
            }
        });
    }, [filteredOffers, sortBy]);

    const clearFilters = () => {
        setSearchTerm('');
        setSelectedCompany('');
        setSortBy('newest');
    };

    const hasActiveFilters = searchTerm || selectedCompany || sortBy !== 'newest';

    return (
        <NavbarLayout>
            <Head title={`${t('offers.pageTitle')} - ${t('company.name')}`} />
            
            {/* Hero Section */}
            <section className={`relative bg-gradient-to-br from-primary/5 via-white to-primary/10 py-16 sm:py-24 ${isRTL ? 'rtl' : ''}`}>
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-from)_0%,_transparent_50%)] from-primary/20"></div>
                
                <div className="relative w-full px-4 sm:px-6 lg:px-8">
                    <div className="w-full">
                        {/* Animated Icon */}
                        <div className="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-2xl bg-primary text-white shadow-lg shadow-primary/25 transition-all duration-500 hover:scale-110 hover:shadow-xl hover:shadow-primary/30">
                            <Gift className="h-10 w-10" />
                        </div>

                        {/* Title with animation */}
                        <h1 className={`mb-6 text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl transition-all duration-700 hover:text-primary ${isRTL ? 'font-arabic text-center' : 'text-center'}`}>
                            {t('offers.pageTitle')}
                        </h1>

                        {/* Subtitle */}
                        <p className={`text-xl text-gray-600 text-center max-w-3xl mx-auto ${isRTL ? 'font-arabic' : ''}`}>
                            {t('offers.pageSubtitle')}
                        </p>
                    </div>
                </div>
            </section>

            {/* Main Content */}
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                {/* Search and Filters */}
                <div className={`bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 ${isRTL ? 'rtl' : ''}`}>
                    <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {/* Search */}
                        <div className="relative">
                            <Search className={`absolute top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400 ${isRTL ? 'right-3' : 'left-3'}`} />
                            <input
                                type="text"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                placeholder={t('offers.searchPlaceholder')}
                                className={`w-full border border-gray-300 rounded-lg focus:ring-primary focus:border-primary ${isRTL ? 'pr-10 pl-4 font-arabic text-right' : 'pl-10 pr-4'} py-2`}
                            />
                        </div>

                        {/* Company Filter */}
                        <select
                            value={selectedCompany}
                            onChange={(e) => setSelectedCompany(e.target.value)}
                            className={`border border-gray-300 rounded-lg focus:ring-primary focus:border-primary px-4 py-2 ${isRTL ? 'font-arabic text-right' : ''}`}
                        >
                            <option value="">{t('offers.allCompanies')}</option>
                            {companies.map(company => (
                                <option key={company} value={company}>{company}</option>
                            ))}
                        </select>

                        {/* Sort */}
                        <select
                            value={sortBy}
                            onChange={(e) => setSortBy(e.target.value)}
                            className={`border border-gray-300 rounded-lg focus:ring-primary focus:border-primary px-4 py-2 ${isRTL ? 'font-arabic text-right' : ''}`}
                        >
                            <option value="newest">{t('offers.sortNewest')}</option>
                            <option value="oldest">{t('offers.sortOldest')}</option>
                            <option value="company">{t('offers.sortCompany')}</option>
                        </select>

                        {/* Clear Filters */}
                        {hasActiveFilters && (
                            <button
                                onClick={clearFilters}
                                className={`flex items-center justify-center gap-2 px-4 py-2 text-gray-600 hover:text-primary transition-colors duration-200 ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}
                            >
                                <X className="h-4 w-4" />
                                {t('offers.clearFilters')}
                            </button>
                        )}
                    </div>
                </div>

                {/* Results Count */}
                {filteredOffers.length > 0 && (
                    <div className="mb-6">
                        <p className={`text-gray-600 ${isRTL ? 'font-arabic text-right' : ''}`}>
                            {t('events.resultsCount', { count: filteredOffers.length })}
                        </p>
                    </div>
                )}

                {/* Offers Grid */}
                {filteredOffers.length > 0 ? (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {filteredOffers.map((offer) => (
                            <OfferCard
                                key={offer.id}
                                offer={offer}
                            />
                        ))}
                    </div>
                ) : (
                    /* No Offers State */
                    <div className={`text-center py-16 ${isRTL ? 'font-arabic' : ''}`}>
                        <div className="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                            <Gift className="h-8 w-8 text-gray-400" />
                        </div>
                        <h3 className="text-lg font-semibold text-gray-900 mb-2">
                            {t('offers.noOffers')}
                        </h3>
                        <p className="text-gray-600 max-w-md mx-auto">
                            {hasActiveFilters ? t('blog.noResultsDescription') : t('offers.noOffersDescription')}
                        </p>
                        {hasActiveFilters && (
                            <button
                                onClick={clearFilters}
                                className="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors duration-200"
                            >
                                <X className="h-4 w-4" />
                                {t('offers.clearFilters')}
                            </button>
                        )}
                    </div>
                )}
            </div>
        </NavbarLayout>
    );
}