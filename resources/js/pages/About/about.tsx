import NavbarLayout from '@/layouts/navbar-layout';
import { Head, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { type SharedData, About as AboutType, BoardMember } from '@/types';
import { Users, Mail, ArrowRight, ArrowLeft } from 'lucide-react';

interface AboutPageProps {
    about: AboutType;
    boardMembers: BoardMember[];
}

export default function About() {
    const { about, boardMembers } = usePage<SharedData & AboutPageProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // Helper function to get content - works with both old and new format
    const getContent = (content: string | Record<string, string>): string => {
        if (typeof content === 'string') {
            return content;
        }
        
        if (typeof content === 'object' && content !== null) {
            const currentLocale = i18n.language || 'en';
            return content[currentLocale] || 
                   content['en'] || 
                   Object.values(content)[0] || 
                   '';
        }
        
        return '';
    };

    return (
        <NavbarLayout>
            <Head title={`${t('about.pageTitle')} - ${t('company.name')}`} />
            
            {/* Hero Section */}
            <section className={`relative bg-gradient-to-br from-primary/5 via-white to-primary/10 py-16 sm:py-24 ${isRTL ? 'rtl' : ''}`}>
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-from)_0%,_transparent_50%)] from-primary/20"></div>
                
                <div className="relative w-full px-4 sm:px-6 lg:px-8">
                    <div className="w-full">
                        {/* Animated Icon */}
                        {/* <div className="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-2xl bg-primary text-white shadow-lg shadow-primary/25 transition-all duration-500 hover:scale-110 hover:shadow-xl hover:shadow-primary/30">
                            <Users className="h-10 w-10" />
                        </div> */}

                        {/* Title with animation */}
                        <h1 className={`mb-6 text-3xl font-bold text-gray-900 sm:text-4xl lg:text-5xl transition-all duration-700 hover:text-primary ${isRTL ? 'font-arabic text-center' : 'text-center'}`}>
                            {getContent(about.title)}
                        </h1>

                        {/* Content */}
                        <div 
                            className={`w-full max-w-5xl mx-auto transition-all duration-500 ${isRTL ? 'font-arabic' : ''} prose prose-lg prose-gray 
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
                            dangerouslySetInnerHTML={{ __html: getContent(about.content) }}
                        />
                    </div>
                </div>
            </section>

            {/* Board Members Section */}
            {about.show_board_section && boardMembers.length > 0 && (
                <section className={`py-16 sm:py-24 bg-white ${isRTL ? 'rtl' : ''}`}>
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {/* Section Header */}
                        <div className="text-center mb-16">
                            <div className={`flex items-center justify-center gap-3 mb-6 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                <div className="flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-white">
                                    <Users className="h-6 w-6" />
                                </div>
                                <h2 className={`text-2xl sm:text-3xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                    {about.board_section_title ? getContent(about.board_section_title) : t('about.ourLeadership')}
                                </h2>
                            </div>
                            
                            {about.board_section_description && (
                                <div 
                                    className={`mx-auto max-w-7xl ${isRTL ? 'font-arabic' : ''} prose prose-gray max-w-none 
                                        prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-4
                                        prose-ul:my-4 prose-ul:space-y-2 prose-ul:mx-auto prose-ul:text-left prose-ul:max-w-max
                                        prose-ol:my-4 prose-ol:space-y-2 prose-ol:mx-auto prose-ol:text-left prose-ol:max-w-max
                                        prose-li:text-gray-600 prose-li:leading-relaxed
                                        prose-strong:text-gray-900 prose-strong:font-semibold
                                        prose-em:text-gray-700 prose-em:italic
                                        [&>*]:text-center [&>*.text-left]:text-left [&>*.text-right]:text-right [&>*.text-justify]:text-justify
                                        ${isRTL ? '[&>*]:text-center [&>*.text-left]:text-left [&>*.text-right]:text-right [&>*.text-justify]:text-justify' : ''}
                                    `}
                                    dangerouslySetInnerHTML={{ __html: getContent(about.board_section_description) }}
                                />
                            )}
                        </div>

                        {/* Board Members Grid */}
                        <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                            {boardMembers.map((member, index) => (
                                <div 
                                    key={member.id}
                                    className="group bg-white rounded-2xl border border-gray-100 p-6 text-center transition-all duration-500 hover:shadow-xl hover:shadow-primary/10 hover:-translate-y-2 hover:border-primary/20 opacity-0 animate-fade-in-up"
                                    style={{
                                        animationDelay: `${index * 150}ms`,
                                        animationFillMode: 'forwards'
                                    }}
                                >
                                    {/* Avatar */}
                                    <div className="mx-auto mb-6 h-24 w-24 overflow-hidden rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-primary/20">
                                        {member.avatar_medium_url ? (
                                            <img
                                                src={member.avatar_medium_url}
                                                alt={getContent(member.name)}
                                                className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                loading="lazy"
                                            />
                                        ) : (
                                            <div className="flex h-full w-full items-center justify-center">
                                                <Users className="h-10 w-10 text-primary/30" />
                                            </div>
                                        )}
                                    </div>

                                    {/* Name */}
                                    <h3 className={`mb-2 text-xl font-semibold text-gray-900 transition-colors duration-300 group-hover:text-primary ${isRTL ? 'font-arabic' : ''}`}>
                                        {getContent(member.name)}
                                    </h3>

                                    {/* Position */}
                                    <p className={`mb-4 text-sm font-medium text-primary ${isRTL ? 'font-arabic' : ''}`}>
                                        {getContent(member.position)}
                                    </p>

                                    {/* Description */}
                                    {member.description && (
                                        <p className={`text-sm text-gray-600 leading-relaxed line-clamp-3 ${isRTL ? 'font-arabic text-right' : ''}`}>
                                            {getContent(member.description)}
                                        </p>
                                    )}

                                    {/* Contact Button */}
                                    <div className="mt-6">
                                        <button className={`inline-flex items-center gap-2 rounded-lg bg-primary/10 px-4 py-2 text-sm font-medium text-primary transition-all duration-300 hover:bg-primary hover:text-white hover:scale-105 ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}>
                                            <Mail className="h-4 w-4" />
                                            <span>{t('about.contactMember')}</span>
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>
            )}
        </NavbarLayout>
    );
}