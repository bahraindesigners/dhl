import NavbarLayout from '@/layouts/navbar-layout';
import { Head, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { DownloadCategory, UserData, SharedData } from '@/types';
import { Link } from '@inertiajs/react';
import { PDFViewer } from '@/components/pdf-viewer';
import { useState, useMemo, useEffect } from 'react';
import { ResourceFilters } from './components/ResourceFilters';
import { ResourceCard } from './components/ResourceCard';

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

    // Filters state
    const [filters, setFilters] = useState({
        search: '',
        category: '',
        accessLevel: '',
        fileType: '',
        sortBy: 'newest'
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
            return content[i18n.language] || content['en'] || Object.values(content)[0] || '';
        }
        
        return '';
    };

    // Get all downloads from all categories
    const allDownloads = useMemo(() => {
        const downloads: any[] = [];
        categories.forEach(category => {
            if (category.downloads && Array.isArray(category.downloads)) {
                category.downloads.forEach(download => {
                    downloads.push({
                        ...download,
                        category_name: renderContent(category.name),
                        category_id: category.id
                    });
                });
            }
        });
        return downloads;
    }, [categories, i18n.language]);

    // Filter and sort downloads
    const filteredDownloads = useMemo(() => {
        let filtered = allDownloads;

        // Apply search filter
        if (filters.search) {
            const searchTerm = filters.search.toLowerCase();
            filtered = filtered.filter(download => 
                renderContent(download.title).toLowerCase().includes(searchTerm) ||
                renderContent(download.description || '').toLowerCase().includes(searchTerm) ||
                download.category_name.toLowerCase().includes(searchTerm)
            );
        }

        // Apply category filter
        if (filters.category) {
            filtered = filtered.filter(download => 
                download.category_id.toString() === filters.category
            );
        }

        // Apply access level filter
        if (filters.accessLevel) {
            filtered = filtered.filter(download => 
                download.access_level === filters.accessLevel
            );
        }

        // Apply file type filter
        if (filters.fileType) {
            filtered = filtered.filter(download => {
                const fileType = download.file_type || '';
                const extension = download.file_extension || '';
                
                switch (filters.fileType) {
                    case 'pdf':
                        return fileType.includes('pdf');
                    case 'doc':
                        return fileType.includes('document') || extension.includes('doc');
                    case 'image':
                        return fileType.includes('image') || ['jpg', 'png', 'gif', 'jpeg'].some(ext => extension.includes(ext));
                    case 'video':
                        return fileType.includes('video');
                    case 'audio':
                        return fileType.includes('audio');
                    case 'spreadsheet':
                        return fileType.includes('spreadsheet') || ['xlsx', 'xls'].some(ext => extension.includes(ext));
                    case 'archive':
                        return fileType.includes('zip') || fileType.includes('rar') || ['zip', 'rar'].some(ext => extension.includes(ext));
                    case 'code':
                        return ['js', 'ts', 'json', 'css', 'html'].some(ext => extension.includes(ext));
                    default:
                        return true;
                }
            });
        }

        // Apply sorting
        switch (filters.sortBy) {
            case 'oldest':
                filtered.sort((a, b) => new Date(a.created_at).getTime() - new Date(b.created_at).getTime());
                break;
            case 'alphabetical':
                filtered.sort((a, b) => renderContent(a.title).localeCompare(renderContent(b.title)));
                break;
            case 'downloads':
                filtered.sort((a, b) => (b.download_count || 0) - (a.download_count || 0));
                break;
            case 'newest':
            default:
                filtered.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime());
                break;
        }

        return filtered;
    }, [allDownloads, filters, renderContent]);

    // Group filtered downloads by category for display
    const groupedFilteredDownloads = useMemo(() => {
        const grouped: { [key: string]: any[] } = {};
        
        filteredDownloads.forEach(download => {
            const categoryName = download.category_name;
            if (!grouped[categoryName]) {
                grouped[categoryName] = [];
            }
            grouped[categoryName].push(download);
        });

        return grouped;
    }, [filteredDownloads]);

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
                                <div className={`flex items-start gap-3 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                    <div className="flex-1">
                                        <p className={`text-amber-800 text-sm ${isRTL ? 'font-arabic text-right' : ''}`}>
                                            {t('resources.memberProfileRequired') || 'Some resources require a complete member profile to access. Complete your profile to unlock all resources.'}
                                        </p>
                                    </div>
                                    <Link
                                        href="/profile"
                                        className="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors whitespace-nowrap"
                                    >
                                        {t('profile.completeProfile') || 'Complete Profile'}
                                    </Link>
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Filters */}
                    <ResourceFilters
                        categories={categories}
                        filters={filters}
                        onFiltersChange={setFilters}
                        totalResults={filteredDownloads.length}
                    />

                    {/* Resources Grid */}
                    {filteredDownloads.length === 0 ? (
                        <div className="text-center py-12">
                            <div className="mb-4">
                                <div className="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg className="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 className={`text-lg font-medium text-foreground mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                                {t('resources.noResultsFound') || 'No resources found'}
                            </h3>
                            <p className={`text-muted-foreground ${isRTL ? 'font-arabic' : ''}`}>
                                {t('resources.noResultsDescription') || 'Try adjusting your search or filters to find what you\'re looking for.'}
                            </p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {filteredDownloads.map((download) => (
                                <ResourceCard
                                    key={download.id}
                                    download={download}
                                    hasProfile={hasProfile}
                                    onViewPdf={openPdfViewer}
                                    renderContent={renderContent}
                                />
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