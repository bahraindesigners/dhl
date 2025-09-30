import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { Users, UserPlus, Star } from 'lucide-react';
import NavbarLayout from '@/layouts/navbar-layout';

interface MembershipPageProps {
    page: {
        how_to_join: Record<string, string>;
        union_benefits: Record<string, string>;
    };
    [key: string]: any;
}

export default function Membership() {
    const { page } = usePage<MembershipPageProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // Helper function to convert TipTap JSON to HTML
    const tiptapToHtml = (tiptapJson: any): string => {
        if (typeof tiptapJson === 'string') {
            return tiptapJson;
        }

        if (!tiptapJson || !tiptapJson.content) {
            return '';
        }

        const processNode = (node: any): string => {
            if (node.type === 'paragraph') {
                const content = node.content ? node.content.map(processNode).join('') : '<br />';
                return `<p>${content}</p>`;
            }

            if (node.type === 'text') {
                return node.text || '';
            }

            if (node.type === 'heading') {
                const level = node.attrs?.level || 1;
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<h${level}>${content}</h${level}>`;
            }

            if (node.type === 'bulletList') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<ul>${content}</ul>`;
            }

            if (node.type === 'orderedList') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<ol>${content}</ol>`;
            }

            if (node.type === 'listItem') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<li>${content}</li>`;
            }

            if (node.type === 'blockquote') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<blockquote>${content}</blockquote>`;
            }

            // Handle other node types as needed
            if (node.content) {
                return node.content.map(processNode).join('');
            }

            return '';
        };

        return tiptapJson.content.map(processNode).join('');
    };

    // Helper function to render content - handles both HTML strings and TipTap JSON
    const renderContent = (content: any): string => {
        // If content is already a string (HTML), return it directly
        if (typeof content === 'string') {
            return content;
        }

        // If content is TipTap JSON, convert it to HTML
        if (content && typeof content === 'object' && content.type === 'doc') {
            return tiptapToHtml(content);
        }

        // Fallback for any other format
        return String(content || '');
    };

    // Get content for current language
    const currentLanguage = i18n.language || 'en';
    const howToJoinContent = page.how_to_join[currentLanguage] || page.how_to_join['en'] || '';
    const unionBenefitsContent = page.union_benefits[currentLanguage] || page.union_benefits['en'] || '';

    return (
        <NavbarLayout>
            <Head title={`${t('membership.pageTitle')} - ${t('company.name')}`} />

            {/* Hero Section */}
            <section className={`relative bg-gradient-to-br from-primary/5 via-white to-primary/10 py-16 sm:py-24 ${isRTL ? 'rtl' : ''}`}>
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-from)_0%,_transparent_50%)] from-primary/20"></div>

                <div className="relative w-full px-4 sm:px-6 lg:px-8">
                    <div className="w-full">
                        {/* Animated Icon */}
                        <div className="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-2xl bg-primary text-white shadow-lg shadow-primary/25 transition-all duration-500 hover:scale-110 hover:shadow-xl hover:shadow-primary/30">
                            <Users className="h-10 w-10" />
                        </div>

                        {/* Title with animation */}
                        <h1 className={`mb-6 text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl transition-all duration-700 hover:text-primary ${isRTL ? 'font-arabic text-center' : 'text-center'}`}>
                            {t('membership.pageTitle')}
                        </h1>

                        {/* Subtitle */}
                        <p className={`text-xl text-gray-600 text-center max-w-3xl mx-auto ${isRTL ? 'font-arabic' : ''}`}>
                            {t('membership.pageSubtitle')}
                        </p>
                    </div>
                </div>
            </section>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
                    {/* How to Join Section */}
                    <div className="space-y-8">
                        <div className={`flex items-center gap-4 `}>
                            <div className="flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-white">
                                <UserPlus className="h-6 w-6" />
                            </div>
                            <h2 className={`text-2xl sm:text-3xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                {t('membership.howToJoin')}
                            </h2>
                        </div>

                        <div
                            className={`transition-all duration-500 ${isRTL ? 'font-arabic' : ''} prose prose-lg prose-gray prose-content max-w-none
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
                                [&>*]:text-left [&>*.text-center]:text-center [&>*.text-right]:text-right [&>*.text-justify]:text-justify
                                ${isRTL ? '[&>*]:text-right [&>*.text-left]:text-left [&>*.text-center]:text-center [&>*.text-justify]:text-justify' : ''}
                            `}
                            dangerouslySetInnerHTML={{ __html: renderContent(howToJoinContent) }}
                        />
                    </div>

                    {/* Union Benefits Section */}
                    <div className="space-y-8">
                        <div className={`flex items-center gap-4 `}>
                            <div className="flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-white">
                                <Star className="h-6 w-6" />
                            </div>
                            <h2 className={`text-2xl sm:text-3xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                {t('membership.unionBenefits')}
                            </h2>
                        </div>

                        <div
                            className={`transition-all duration-500 ${isRTL ? 'font-arabic' : ''} prose prose-lg prose-gray prose-content max-w-none
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
                                [&>*]:text-left [&>*.text-center]:text-center [&>*.text-right]:text-right [&>*.text-justify]:text-justify
                                ${isRTL ? '[&>*]:text-right [&>*.text-left]:text-left [&>*.text-center]:text-center [&>*.text-justify]:text-justify' : ''}
                            `}
                            dangerouslySetInnerHTML={{ __html: renderContent(unionBenefitsContent) }}
                        />
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}