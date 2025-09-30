import { PageProps, FAQ, FAQCategory } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { useState } from 'react';
import NavbarLayout from '@/layouts/navbar-layout';
import { useDebouncedSearch } from '@/hooks/use-debounced-search';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import { Button } from '@/components/ui/button';
import { SearchInput } from '@/components/ui/search-input';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { 
    ChevronDown, 
    ChevronUp, 
    Star, 
    HelpCircle,
    MessageCircle,
    Sparkles,
    TrendingUp,
    Users,
    Clock,
    BookOpen
} from 'lucide-react';
import { cn } from '@/lib/utils';

interface QAPageProps extends PageProps {
    categories: FAQCategory[];
    featuredFaqs: FAQ[];
}

export default function QuestionsAndAnswers() {
    const { categories, featuredFaqs } = usePage<QAPageProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';
    const { searchQuery, debouncedSearchQuery, handleSearchChange, clearSearch } = useDebouncedSearch();
    const [openItems, setOpenItems] = useState<Set<number>>(new Set());

    const toggleItem = (id: number) => {
        const newOpenItems = new Set(openItems);
        if (newOpenItems.has(id)) {
            newOpenItems.delete(id);
        } else {
            newOpenItems.add(id);
        }
        setOpenItems(newOpenItems);
    };

    // Helper function to get translated content
    const getTranslatedContent = (content: string | Record<string, string>): string => {
        if (typeof content === 'string') {
            return content;
        }
        return content[i18n.language] || content['en'] || Object.values(content)[0] || '';
    };

    // Scroll to category function
    const scrollToCategory = (categoryId: number) => {
        const element = document.getElementById(`category-${categoryId}`);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    // Filter FAQs based on search and category (using debounced search)
    const filteredCategories = categories.map(category => ({
        ...category,
        faqs: category.faqs.filter((faq: FAQ) => {
            const question = getTranslatedContent(faq.question);
            const answer = getTranslatedContent(faq.answer);
            const matchesSearch = debouncedSearchQuery === '' || 
                question.toLowerCase().includes(debouncedSearchQuery.toLowerCase()) ||
                answer.toLowerCase().includes(debouncedSearchQuery.toLowerCase());
            
            return matchesSearch;
        })
    })).filter(category => category.faqs.length > 0);

    const filteredFeaturedFaqs = featuredFaqs.filter((faq: FAQ) => {
        const question = getTranslatedContent(faq.question);
        const answer = getTranslatedContent(faq.answer);
        const matchesSearch = debouncedSearchQuery === '' || 
            question.toLowerCase().includes(debouncedSearchQuery.toLowerCase()) ||
            answer.toLowerCase().includes(debouncedSearchQuery.toLowerCase());
        
        return matchesSearch;
    });

    return (
        <NavbarLayout>
            <Head title={t('nav.qanda')} />
            
            {/* Hero Section - Matching News Page Style */}
            <section className={`relative bg-gradient-to-br from-primary/5 via-white to-primary/10 py-8 sm:py-12 ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-from)_0%,_transparent_50%)] from-primary/20"></div>
                
                <div className="relative w-full px-4 sm:px-6 lg:px-8">
                    <div className="w-full">
                        {/* Animated Icon */}
                        <div className="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/20 to-primary/10 backdrop-blur-sm">
                            <HelpCircle className="h-7 w-7 text-primary" />
                        </div>

                        {/* Title */}
                        <h1 className={`text-center text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl ${isRTL ? 'font-arabic' : ''}`}>
                            {t('nav.qanda')}
                        </h1>
                        <p className={`mx-auto mt-3 max-w-2xl text-center text-base leading-7 text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('nav.qandaDescription')}
                        </p>
                    </div>
                </div>
            </section>

            {/* Search Section */}
            <section className="py-8 bg-gray-50/50">
                <div className={`mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                    <SearchInput
                        placeholder={t('common.searchPlaceholder')}
                        value={searchQuery}
                        onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleSearchChange(e.target.value)}
                        onClear={clearSearch}
                        showSearchKeyboard={true}
                        className={`h-12 bg-white border-gray-200 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary shadow-sm ${isRTL ? 'text-right' : 'text-left'}`}
                        dir={isRTL ? 'rtl' : 'ltr'}
                    />
                    {debouncedSearchQuery && (
                        <p className={`mt-2 text-center text-sm text-gray-500 ${isRTL ? 'font-arabic' : ''}`}>
                            {filteredCategories.reduce((total, cat) => total + cat.faqs.length, 0)} {t('common.resultsFound')}
                        </p>
                    )}
                </div>
            </section>

            {/* Main Content */}
            <section className="py-16">
                <div className={`mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                    {!debouncedSearchQuery ? (
                        <>
                            {/* Categories */}
                            <div className="mb-16">
                                <h2 className={`text-2xl font-bold text-gray-900 mb-8 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                    {t('qa.browseByCategory')}
                                </h2>
                                <div className="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                    {categories.map((category) => (
                                        <Card 
                                            key={category.id} 
                                            className="group cursor-pointer transition-all duration-200 hover:shadow-lg hover:scale-[1.02] border-gray-200 bg-white"
                                            onClick={() => scrollToCategory(category.id)}
                                        >
                                            <CardHeader className="p-5">
                                                <div className={`flex items-center ${isRTL ? 'gap-x-reverse' : ''} gap-x-3`}>
                                                    <div className="flex-shrink-0 h-10 w-10 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                                        <BookOpen className="h-5 w-5 text-primary" />
                                                    </div>
                                                    <div className="flex-1 min-w-0">
                                                        <h3 className={`text-sm font-semibold text-gray-900 truncate group-hover:text-primary transition-colors ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                            {getTranslatedContent(category.name)}
                                                        </h3>
                                                        <p className={`text-xs text-gray-500 mt-1 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                            {category.faqs.length} {t('common.questions')}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className={`mt-3 flex items-center justify-between text-xs text-gray-400 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                                    <span className={isRTL ? 'font-arabic' : ''}>{t('common.clickToView')}</span>
                                                    <ChevronDown className={`h-4 w-4 group-hover:text-primary transition-colors ${isRTL ? 'rotate-180' : ''}`} />
                                                </div>
                                            </CardHeader>
                                        </Card>
                                    ))}
                                </div>
                            </div>

                            {/* Featured FAQs - Simplified */}
                            {featuredFaqs.length > 0 && (
                                <div className="mb-16">
                                    <Card className="bg-gradient-to-r from-gray-50 to-gray-100/50 border-gray-200">
                                        <CardHeader className="text-center py-8">
                                            <div className="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10">
                                                <Star className="h-6 w-6 text-primary" />
                                            </div>
                                            <CardTitle className={`text-2xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                                {t('qa.featured')}
                                            </CardTitle>
                                            <CardDescription className={`text-gray-600 max-w-2xl mx-auto ${isRTL ? 'font-arabic' : ''}`}>
                                                {t('qa.featuredDescription')}
                                            </CardDescription>
                                        </CardHeader>
                                        <CardContent className="pb-8">
                                            <div className="space-y-3">
                                                {featuredFaqs.map((faq) => (
                                                    <Collapsible key={faq.id} open={openItems.has(faq.id)} onOpenChange={() => toggleItem(faq.id)}>
                                                        <Card className="border-gray-200 hover:shadow-sm transition-shadow">
                                                            <CollapsibleTrigger asChild>
                                                                <CardHeader className="cursor-pointer hover:bg-gray-50/50 transition-colors p-4">
                                                                    <div className="flex items-start justify-between gap-4">
                                                                        <div className={`flex items-start ${isRTL ? 'gap-x-reverse' : ''} gap-x-3 flex-1 min-w-0`}>
                                                                            <div className="flex-shrink-0 mt-1">
                                                                                <Star className="h-4 w-4 text-gray-400" />
                                                                            </div>
                                                                            <CardTitle className={`text-base font-medium text-gray-900 leading-snug ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                                                {getTranslatedContent(faq.question)}
                                                                            </CardTitle>
                                                                        </div>
                                                                        <div className="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors flex-shrink-0">
                                                                            {openItems.has(faq.id) ? (
                                                                                <ChevronUp className="h-3 w-3 text-gray-600" />
                                                                            ) : (
                                                                                <ChevronDown className="h-3 w-3 text-gray-600" />
                                                                            )}
                                                                        </div>
                                                                    </div>
                                                                </CardHeader>
                                                            </CollapsibleTrigger>
                                                            <CollapsibleContent>
                                                                <CardContent className="px-4 pb-4 pt-0">
                                                                    <div className="h-px bg-gray-200 mb-3"></div>
                                                                    <div 
                                                                        className={`prose prose-sm max-w-none text-gray-600 leading-relaxed ${isRTL ? 'prose-rtl [&>*]:text-right font-arabic' : ''}`}
                                                                        dangerouslySetInnerHTML={{ __html: getTranslatedContent(faq.answer) }}
                                                                    />
                                                                </CardContent>
                                                            </CollapsibleContent>
                                                        </Card>
                                                    </Collapsible>
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>
                                </div>
                            )}

                            {/* FAQ Categories */}
                            <div className="space-y-12">
                                {categories.map((category) => (
                                    <section key={category.id} id={`category-${category.id}`}>
                                        <Card className="border-gray-200">
                                            <CardHeader className="border-b border-gray-100 bg-gray-50/50">
                                                <div className={`flex items-center ${isRTL ? 'gap-x-reverse' : ''} gap-x-3`}>
                                                    <div className="h-10 w-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                                        <BookOpen className="h-5 w-5 text-primary" />
                                                    </div>
                                                    <div className="flex-1">
                                                        <CardTitle className={`text-xl font-semibold text-gray-900 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                            {getTranslatedContent(category.name)}
                                                        </CardTitle>
                                                        <p className={`text-sm text-gray-500 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                            {category.faqs.length} {t('common.questions')}
                                                        </p>
                                                    </div>
                                                </div>
                                            </CardHeader>
                                            <CardContent className="p-0">
                                                <div className="space-y-0">
                                                    {category.faqs.map((faq, index) => (
                                                        <Collapsible key={faq.id} open={openItems.has(faq.id)} onOpenChange={() => toggleItem(faq.id)}>
                                                            <CollapsibleTrigger asChild>
                                                                <CardHeader className={`cursor-pointer hover:bg-gray-50 transition-colors px-6 py-4 ${index > 0 ? 'border-t border-gray-100' : ''}`}>
                                                                    <div className="flex items-center justify-between gap-4">
                                                                        <div className={`flex items-center ${isRTL ? 'gap-x-reverse' : ''} gap-x-3 flex-1`}>
                                                                            {faq.is_featured && (
                                                                                <div className="flex-shrink-0">
                                                                                    <Badge variant="secondary" className="bg-gray-100 text-gray-600 hover:bg-gray-200">
                                                                                        <Star className="h-3 w-3 mr-1" />
                                                                                        {t('qa.featured')}
                                                                                    </Badge>
                                                                                </div>
                                                                            )}
                                                                            <CardTitle className={`text-lg font-semibold text-gray-900 leading-tight ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                                                {getTranslatedContent(faq.question)}
                                                                            </CardTitle>
                                                                        </div>
                                                                        <div className="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                                                            {openItems.has(faq.id) ? (
                                                                                <ChevronUp className="h-4 w-4 text-gray-600" />
                                                                            ) : (
                                                                                <ChevronDown className="h-4 w-4 text-gray-600" />
                                                                            )}
                                                                        </div>
                                                                    </div>
                                                                </CardHeader>
                                                            </CollapsibleTrigger>
                                                            <CollapsibleContent>
                                                                <CardContent className="px-6 pb-6 pt-0">
                                                                    <div className="h-px bg-gray-200 mb-4"></div>
                                                                    <div 
                                                                        className={`prose prose-sm max-w-none text-gray-700 leading-relaxed ${isRTL ? 'prose-rtl [&>*]:text-right font-arabic' : ''}`}
                                                                        dangerouslySetInnerHTML={{ __html: getTranslatedContent(faq.answer) }}
                                                                    />
                                                                </CardContent>
                                                            </CollapsibleContent>
                                                        </Collapsible>
                                                    ))}
                                                </div>
                                            </CardContent>
                                        </Card>
                                    </section>
                                ))}
                            </div>
                        </>
                    ) : (
                        /* Search Results */
                        <div className="space-y-8">
                            {filteredFeaturedFaqs.length > 0 && (
                                <div>
                                    <h2 className={`text-xl font-semibold text-gray-900 mb-4 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                        {t('qa.featured')}
                                    </h2>
                                    <div className="space-y-3">
                                        {filteredFeaturedFaqs.map((faq) => (
                                            <Collapsible key={faq.id} open={openItems.has(faq.id)} onOpenChange={() => toggleItem(faq.id)}>
                                                <Card className="border-gray-200 hover:shadow-sm transition-shadow">
                                                    <CollapsibleTrigger asChild>
                                                        <CardHeader className="cursor-pointer hover:bg-gray-50/50 transition-colors p-4">
                                                            <div className="flex items-start justify-between gap-4">
                                                                <div className={`flex items-start ${isRTL ? 'gap-x-reverse' : ''} gap-x-3 flex-1 min-w-0`}>
                                                                    <div className="flex-shrink-0 mt-1">
                                                                        <Star className="h-4 w-4 text-gray-400" />
                                                                    </div>
                                                                    <CardTitle className={`text-base font-medium text-gray-900 leading-snug ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                                        {getTranslatedContent(faq.question)}
                                                                    </CardTitle>
                                                                </div>
                                                                <div className="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors flex-shrink-0">
                                                                    {openItems.has(faq.id) ? (
                                                                        <ChevronUp className="h-3 w-3 text-gray-600" />
                                                                    ) : (
                                                                        <ChevronDown className="h-3 w-3 text-gray-600" />
                                                                    )}
                                                                </div>
                                                            </div>
                                                        </CardHeader>
                                                    </CollapsibleTrigger>
                                                    <CollapsibleContent>
                                                        <CardContent className="px-4 pb-4 pt-0">
                                                            <div className="h-px bg-gray-200 mb-3"></div>
                                                            <div 
                                                                className={`prose prose-sm max-w-none text-gray-600 leading-relaxed ${isRTL ? 'prose-rtl [&>*]:text-right font-arabic' : ''}`}
                                                                dangerouslySetInnerHTML={{ __html: getTranslatedContent(faq.answer) }}
                                                            />
                                                        </CardContent>
                                                    </CollapsibleContent>
                                                </Card>
                                            </Collapsible>
                                        ))}
                                    </div>
                                </div>
                            )}

                            {filteredCategories.map((category) => (
                                <div key={category.id} id={`category-${category.id}`}>
                                    <h2 className={`text-xl font-semibold text-gray-900 mb-4 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                        {getTranslatedContent(category.name)}
                                    </h2>
                                    <div className="space-y-3">
                                        {category.faqs.map((faq) => (
                                            <Collapsible key={faq.id} open={openItems.has(faq.id)} onOpenChange={() => toggleItem(faq.id)}>
                                                <Card className="border-gray-200 hover:shadow-sm transition-shadow">
                                                    <CollapsibleTrigger asChild>
                                                        <CardHeader className="cursor-pointer hover:bg-gray-50/50 transition-colors p-4">
                                                            <div className="flex items-start justify-between gap-4">
                                                                <CardTitle className={`text-base font-medium text-gray-900 leading-snug flex-1 ${isRTL ? 'text-right font-arabic' : 'text-left'}`}>
                                                                    {getTranslatedContent(faq.question)}
                                                                </CardTitle>
                                                                <div className="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors flex-shrink-0">
                                                                    {openItems.has(faq.id) ? (
                                                                        <ChevronUp className="h-3 w-3 text-gray-600" />
                                                                    ) : (
                                                                        <ChevronDown className="h-3 w-3 text-gray-600" />
                                                                    )}
                                                                </div>
                                                            </div>
                                                        </CardHeader>
                                                    </CollapsibleTrigger>
                                                    <CollapsibleContent>
                                                        <CardContent className="px-4 pb-4 pt-0">
                                                            <div className="h-px bg-gray-200 mb-3"></div>
                                                            <div 
                                                                className={`prose prose-sm max-w-none text-gray-600 leading-relaxed ${isRTL ? 'prose-rtl [&>*]:text-right font-arabic' : ''}`}
                                                                dangerouslySetInnerHTML={{ __html: getTranslatedContent(faq.answer) }}
                                                            />
                                                        </CardContent>
                                                    </CollapsibleContent>
                                                </Card>
                                            </Collapsible>
                                        ))}
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}

                    {/* No Results */}
                    {filteredCategories.length === 0 && filteredFeaturedFaqs.length === 0 && debouncedSearchQuery && (
                        <Card className="text-center py-16 border-dashed border-gray-300">
                            <CardContent className="p-8">
                                <div className="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                    <HelpCircle className="h-8 w-8" />
                                </div>
                                <h3 className={`text-lg font-semibold text-gray-900 mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                                    {t('common.noResults')}
                                </h3>
                                <p className={`text-gray-500 ${isRTL ? 'font-arabic' : ''}`}>
                                    {t('common.tryDifferentSearch')}
                                </p>
                            </CardContent>
                        </Card>
                    )}
                </div>
            </section>
        </NavbarLayout>
    );
}