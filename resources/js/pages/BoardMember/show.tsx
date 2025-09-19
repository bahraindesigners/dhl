import NavbarLayout from '@/layouts/navbar-layout';
import { Head, Link, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { type SharedData, BoardMember } from '@/types';
import { Users, ArrowLeft, ArrowRight, ChevronLeft, ChevronRight } from 'lucide-react';

interface BoardMemberPageProps {
    boardMember: BoardMember;
    otherMembers: Array<{
        id: number;
        name: string | Record<string, string>;
        position: string | Record<string, string>;
        slug: number;
    }>;
}

export default function ShowBoardMember() {
    const { boardMember, otherMembers } = usePage<SharedData & BoardMemberPageProps>().props;
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
                const content = node.content ? node.content.map(processNode).join('') : '';
                // Always return paragraph tags, even if empty - this preserves line breaks
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

    return (
        <NavbarLayout>
            <Head title={`${renderContent(boardMember.name)} - ${t('about.ourLeadership')} - ${t('company.name')}`} />
            
            {/* Breadcrumb */}
            {/* <section className="bg-gray-50 py-4">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <nav className={`flex items-center space-x-2 text-sm ${isRTL ? 'flex-row-reverse space-x-reverse font-arabic' : ''}`}>
                        <Link href="/" className="text-gray-600 hover:text-primary transition-colors">
                            {t('navigation.home')}
                        </Link>
                        {isRTL ? <ChevronLeft className="h-4 w-4 text-gray-400" /> : <ChevronRight className="h-4 w-4 text-gray-400" />}
                        <Link href="/about" className="text-gray-600 hover:text-primary transition-colors">
                            {t('about.pageTitle')}
                        </Link>
                        {isRTL ? <ChevronLeft className="h-4 w-4 text-gray-400" /> : <ChevronRight className="h-4 w-4 text-gray-400" />}
                        <span className="text-gray-900 font-medium">{renderContent(boardMember.name)}</span>
                    </nav>
                </div>
            </section> */}

            {/* Hero Section */}
            <section className={`relative bg-gradient-to-br from-primary/5 via-white to-primary/10 py-16 sm:py-24 ${isRTL ? 'rtl' : ''}`}>
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-from)_0%,_transparent_50%)] from-primary/20"></div>
                
                <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {/* Back Button */}
                    {/* <div className={`mb-8 ${isRTL ? 'text-right' : 'text-left'}`}>
                        <Link 
                            href="/about" 
                            className={`inline-flex items-center gap-2 text-primary hover:text-primary/80 font-medium transition-all duration-300 hover:gap-3 ${isRTL ? 'flex-row-reverse font-arabic' : ''}`}
                        >
                            {isRTL ? <ArrowRight className="h-5 w-5" /> : <ArrowLeft className="h-5 w-5" />}
                            <span>{t('common.back')}</span>
                        </Link>
                    </div> */}

                    <div className={`grid lg:grid-cols-3 gap-12 items-start ${isRTL ? 'lg:grid-flow-col-dense' : ''}`}>
                        {/* Profile Image */}
                        <div className={`lg:col-span-1 ${isRTL ? 'lg:order-last' : ''}`}>
                            <div className="text-center">
                                <div className="mx-auto w-80 h-80 overflow-hidden rounded-3xl bg-gradient-to-br from-primary/10 to-primary/5 shadow-2xl shadow-primary/20 mb-8">
                                    {boardMember.avatar_medium_url || boardMember.avatar_url ? (
                                        <img
                                            src={boardMember.avatar_medium_url || boardMember.avatar_url}
                                            alt={renderContent(boardMember.name)}
                                            className="h-full w-full object-cover"
                                            loading="eager"
                                        />
                                    ) : (
                                        <div className="flex h-full w-full items-center justify-center">
                                            <Users className="h-32 w-32 text-primary/30" />
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Content */}
                        <div className="lg:col-span-2">
                            {/* Header */}
                            <div className={`mb-8 ${isRTL ? 'text-right' : ''}`}>
                                <h1 className={`text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 ${isRTL ? 'font-arabic' : ''}`}>
                                    {renderContent(boardMember.name)}
                                </h1>
                                <p className={`text-xl sm:text-2xl text-primary font-medium mb-8 ${isRTL ? 'font-arabic' : ''}`}>
                                    {renderContent(boardMember.position)}
                                </p>
                            </div>

                            {/* Description */}
                            {boardMember.description && (
                                <div className="mb-8">
                                    <div 
                                        className={`prose prose-lg prose-gray max-w-none prose-content
                                            prose-headings:text-gray-900 prose-headings:font-bold
                                            prose-h1:text-3xl prose-h1:mb-6 prose-h1:mt-8
                                            prose-h2:text-2xl prose-h2:mb-4 prose-h2:mt-6 prose-h2:text-primary
                                            prose-h3:text-xl prose-h3:mb-3 prose-h3:mt-5 prose-h3:text-gray-800
                                            prose-p:text-gray-600 prose-p:leading-relaxed prose-p:mb-4 prose-p:text-lg
                                            prose-ul:my-4 prose-ul:space-y-2
                                            prose-ol:my-4 prose-ol:space-y-2
                                            prose-li:text-gray-600 prose-li:leading-relaxed
                                            prose-strong:text-gray-900 prose-strong:font-semibold
                                            prose-em:text-gray-700 prose-em:italic
                                            prose-blockquote:border-l-4 prose-blockquote:border-primary prose-blockquote:pl-4 prose-blockquote:italic prose-blockquote:text-gray-700
                                            prose-a:text-primary prose-a:no-underline hover:prose-a:underline
                                            [&>*]:text-left [&>*.text-center]:text-center [&>*.text-right]:text-right [&>*.text-justify]:text-justify
                                            ${isRTL ? 'font-arabic prose-blockquote:border-r-4 prose-blockquote:border-l-0 prose-blockquote:pr-4 prose-blockquote:pl-0 [&>*]:text-right [&>*.text-left]:text-left [&>*.text-center]:text-center [&>*.text-justify]:text-justify' : ''}
                                        `}
                                        dangerouslySetInnerHTML={{ __html: renderContent(boardMember.description) }}
                                    />
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </section>

            {/* Other Board Members */}
            {otherMembers.length > 0 && (
                <section className={`py-16 bg-white ${isRTL ? 'rtl' : ''}`}>
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <h2 className={`text-2xl sm:text-3xl font-bold text-gray-900 mb-8 ${isRTL ? 'font-arabic text-right' : ''}`}>
                            {t('boardMember.otherMembers')}
                        </h2>
                        
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            {otherMembers.map((member) => (
                                <Link
                                    key={member.id}
                                    href={`/board-member/${member.slug}`}
                                    className="group bg-gray-50 rounded-xl p-6 hover:bg-primary/5 hover:shadow-lg transition-all duration-300"
                                >
                                    <h3 className={`font-semibold text-gray-900 group-hover:text-primary transition-colors ${isRTL ? 'font-arabic text-right' : ''}`}>
                                        {renderContent(member.name)}
                                    </h3>
                                    <p className={`text-sm text-gray-600 mt-1 ${isRTL ? 'font-arabic text-right' : ''}`}>
                                        {renderContent(member.position)}
                                    </p>
                                </Link>
                            ))}
                        </div>
                    </div>
                </section>
            )}
        </NavbarLayout>
    );
}