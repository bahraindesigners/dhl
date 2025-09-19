import NavbarLayout from '@/layouts/navbar-layout';
import { Head, Link, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { DownloadCategory, UserData, SharedData } from '@/types';
import { Download as DownloadIcon, Lock, User, Eye, FileText, Calendar, ArrowDownCircle, File, FileImage, FileType, FileArchive, FileVideo, FileAudio, FileSpreadsheet, FileCode } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { PDFViewer } from '@/components/pdf-viewer';
import { useState } from 'react';

interface ResourcesPageProps {
    categories: DownloadCategory[];
    hasProfile: boolean;
    user: UserData | null;
}

export default function Resources() {
    const { categories: rawCategories = [], hasProfile = false, user } = usePage<SharedData & ResourcesPageProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    // PDF Viewer state
    const [pdfViewer, setPdfViewer] = useState<{
        isOpen: boolean;
        pdfUrl: string;
        title: string;
        downloadUrl: string;
    }>({
        isOpen: false,
        pdfUrl: '',
        title: '',
        downloadUrl: ''
    });

    // Ensure categories is always an array - handle both array and object formats
    const categories: DownloadCategory[] = Array.isArray(rawCategories) 
        ? rawCategories 
        : Object.values(rawCategories || {}) as DownloadCategory[];

    // Debug logging
    console.log('Resources page loaded:', {
        categoriesCount: categories.length,
        categoriesType: typeof rawCategories,
        isArray: Array.isArray(rawCategories),
        userAuthenticated: !!user,
        hasProfile: hasProfile,
        rawData: rawCategories
    });

    // Helper function to render content based on locale
    const renderContent = (content: string | Record<string, string>): string => {
        if (typeof content === 'string') {
            return content;
        }
        if (typeof content === 'object' && content !== null) {
            return content[i18n.language] || content.en || '';
        }
        return '';
    };

    const getAccessIcon = (accessLevel: string) => {
        switch (accessLevel) {
            case 'public':
                return <Eye className="h-4 w-4 text-green-500" />;
            case 'members':
                return <User className="h-4 w-4 text-blue-500" />;
            default:
                return <FileText className="h-4 w-4 text-gray-500" />;
        }
    };

    const getAccessBadgeColor = (accessLevel: string) => {
        switch (accessLevel) {
            case 'public':
                return 'bg-green-100 text-green-800 border-green-200';
            case 'members':
                return 'bg-blue-100 text-blue-800 border-blue-200';
            default:
                return 'bg-gray-100 text-gray-800 border-gray-200';
        }
    };

    const canDownload = (download: any) => {
        if (download.access_level === 'public') return true;
        if (download.access_level === 'members' && hasProfile) return true;
        return false;
    };

    const isPdfFile = (download: any) => {
        return download.file_type && download.file_type.includes('pdf');
    };

    const getFileTypeIcon = (download: any) => {
        const fileType = download.file_type || '';
        const extension = download.file_extension || '';
        
        if (fileType.includes('pdf')) {
            return <FileType className="h-8 w-8 text-red-500" />;
        } else if (fileType.includes('image')) {
            return <FileImage className="h-8 w-8 text-green-500" />;
        } else if (fileType.includes('video')) {
            return <FileVideo className="h-8 w-8 text-purple-500" />;
        } else if (fileType.includes('audio')) {
            return <FileAudio className="h-8 w-8 text-orange-500" />;
        } else if (fileType.includes('spreadsheet') || extension.includes('xlsx') || extension.includes('xls')) {
            return <FileSpreadsheet className="h-8 w-8 text-green-600" />;
        } else if (fileType.includes('zip') || fileType.includes('rar') || extension.includes('zip')) {
            return <FileArchive className="h-8 w-8 text-yellow-500" />;
        } else if (extension.includes('js') || extension.includes('ts') || extension.includes('json')) {
            return <FileCode className="h-8 w-8 text-blue-500" />;
        } else {
            return <File className="h-8 w-8 text-gray-500" />;
        }
    };

    const openPdfViewer = (download: any) => {
        // Construct the PDF URL for viewing
        const pdfUrl = `/resources/${download.id}/view`;
        const downloadUrl = `/resources/${download.id}/download`;
        
        setPdfViewer({
            isOpen: true,
            pdfUrl,
            title: renderContent(download.title),
            downloadUrl
        });
    };

    const closePdfViewer = () => {
        setPdfViewer({
            isOpen: false,
            pdfUrl: '',
            title: '',
            downloadUrl: ''
        });
    };

    return (
        <NavbarLayout>
            <Head title={`${t('nav.resources') || 'Resources'} - ${t('company.name')}`} />
            
            <div className="container mx-auto px-4 py-8">
                <div className="max-w-6xl mx-auto">
                    {/* Header */}
                    <div className={`mb-8 ${isRTL ? 'text-right' : 'text-left'}`}>
                        <h1 className={`text-3xl font-bold text-foreground mb-4 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('nav.resources') || 'Resources'}
                        </h1>
                        
                        {!hasProfile && (
                            <div className="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                                <div className="flex items-start gap-3">
                                    <Lock className="h-5 w-5 text-amber-600 mt-0.5 flex-shrink-0" />
                                    <div className={isRTL ? 'text-right' : 'text-left'}>
                                        <p className={`text-amber-800 text-sm ${isRTL ? 'font-arabic' : ''}`}>
                                            {t('resources.memberProfileRequired') || 'Some resources require a complete member profile to access. Complete your profile to unlock all resources.'}
                                        </p>
                                        {!user && (
                                            <Link href="/login" className="text-amber-700 underline text-sm font-medium mt-1 inline-block">
                                                {t('auth.signIn') || 'Sign In'}
                                            </Link>
                                        )}
                                        {user && !hasProfile && (
                                            <Link href="/profile" className="text-amber-700 underline text-sm font-medium mt-1 inline-block">
                                                {t('events.completeProfile') || 'Complete Profile'}
                                            </Link>
                                        )}
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Categories */}
                    {!categories || categories.length === 0 ? (
                        <div className="text-center py-12">
                            <FileText className="h-12 w-12 text-gray-400 mx-auto mb-4" />
                            <p className={`text-gray-500 ${isRTL ? 'font-arabic' : ''}`}>
                                {t('resources.noResources') || 'No resources available at this time.'}
                            </p>
                        </div>
                    ) : (
                        <div className="space-y-8">
                            {(categories || []).map((category) => (
                                <div key={category.id} className="bg-white border border-border rounded-lg p-6">
                                    <div className={`flex items-center gap-3 mb-6 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                        <FileText className="h-6 w-6 text-primary" />
                                        <h2 className={`text-xl font-semibold text-foreground ${isRTL ? 'font-arabic' : ''}`}>
                                            {renderContent(category.name)}
                                        </h2>
                                    </div>
                                    
                                    {category.description && (
                                        <p className={`text-muted-foreground mb-6 text-sm ${isRTL ? 'font-arabic text-right' : ''}`}>
                                            {renderContent(category.description)}
                                        </p>
                                    )}

                                    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                        {(category.downloads || []).map((download) => (
                                            <div key={download.id} className="group bg-white border border-border rounded-xl p-6 hover:shadow-lg hover:border-primary/20 transition-all duration-200 hover:-translate-y-1">
                                                {/* File Icon and Access Badge Row */}
                                                <div className="flex items-start justify-between mb-4">
                                                    <div className="flex items-center gap-3">
                                                        <div className="p-2 bg-gray-50 rounded-lg group-hover:bg-primary/5 transition-colors">
                                                            {getFileTypeIcon(download)}
                                                        </div>
                                                        <div className="flex flex-col">
                                                            <span className="text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                                                {download.file_extension || download.file_type?.split('/')[1] || 'File'}
                                                            </span>
                                                            {download.file_size_formatted && (
                                                                <span className="text-xs text-muted-foreground">
                                                                    {download.file_size_formatted}
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>
                                                    <div className={`flex items-center gap-1 px-2 py-1 rounded-full border text-xs font-medium ${getAccessBadgeColor(download.access_level)}`}>
                                                        {getAccessIcon(download.access_level)}
                                                        <span className={isRTL ? 'font-arabic' : ''}>
                                                            {download.access_level === 'public' ? (t('resources.publicAccess') || 'Public') : 
                                                             download.access_level === 'members' ? (t('resources.membersOnly') || 'Members Only') : 
                                                             download.access_level_label}
                                                        </span>
                                                    </div>
                                                </div>

                                                {/* Title */}
                                                <h3 className={`font-semibold text-foreground mb-2 text-base leading-tight line-clamp-2 group-hover:text-primary transition-colors ${isRTL ? 'font-arabic text-right' : ''}`}>
                                                    {renderContent(download.title)}
                                                </h3>

                                                {/* Description */}
                                                {download.description && (
                                                    <p className={`text-muted-foreground text-sm mb-4 line-clamp-2 leading-relaxed ${isRTL ? 'font-arabic text-right' : ''}`}>
                                                        {renderContent(download.description)}
                                                    </p>
                                                )}

                                                {/* Stats Row */}
                                                {download.download_count > 0 && (
                                                    <div className="flex items-center gap-1 mb-4 text-xs text-muted-foreground">
                                                        <ArrowDownCircle className="h-3 w-3" />
                                                        <span>{download.download_count} {t('resources.downloads') || 'downloads'}</span>
                                                    </div>
                                                )}

                                                {/* Action Buttons */}
                                                <div className={`flex items-center gap-2 pt-4 border-t border-gray-100 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                                    {canDownload(download) ? (
                                                        <>
                                                            {/* View button for PDFs */}
                                                            {isPdfFile(download) && (
                                                                <Button
                                                                    size="sm"
                                                                    variant="outline"
                                                                    onClick={() => openPdfViewer(download)}
                                                                    className="flex-1 h-9 text-xs font-medium hover:bg-primary hover:text-primary-foreground transition-colors"
                                                                >
                                                                    <Eye className="h-3 w-3 mr-1" />
                                                                    {t('resources.view') || 'View'}
                                                                </Button>
                                                            )}
                                                            
                                                            {/* Download button */}
                                                            <Button
                                                                asChild
                                                                size="sm"
                                                                className={`h-9 text-xs font-medium ${isPdfFile(download) ? 'flex-1' : 'w-full'}`}
                                                            >
                                                                <a href={`/resources/${download.id}/download`}>
                                                                    <ArrowDownCircle className="h-3 w-3 mr-1" />
                                                                    {t('resources.download') || 'Download'}
                                                                </a>
                                                            </Button>
                                                        </>
                                                    ) : (
                                                        <Button
                                                            size="sm"
                                                            variant="outline"
                                                            disabled
                                                            className="w-full h-9 text-xs font-medium"
                                                        >
                                                            <Lock className="h-3 w-3 mr-1" />
                                                            {t('resources.restricted') || 'Restricted'}
                                                        </Button>
                                                    )}
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>

            {/* PDF Viewer Modal */}
            <PDFViewer
                isOpen={pdfViewer.isOpen}
                onClose={closePdfViewer}
                pdfUrl={pdfViewer.pdfUrl}
                title={pdfViewer.title}
                downloadUrl={pdfViewer.downloadUrl}
            />
        </NavbarLayout>
    );
}