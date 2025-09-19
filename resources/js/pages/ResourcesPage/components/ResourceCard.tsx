import { useTranslation } from 'react-i18next';
import { Eye, Lock, User, FileText, ArrowDownCircle, File, FileImage, FileType, FileArchive, FileVideo, FileAudio, FileSpreadsheet, FileCode } from 'lucide-react';
import { Button } from '@/components/ui/button';

interface ResourceCardProps {
    download: any;
    hasProfile: boolean;
    onViewPdf: (download: any) => void;
    renderContent: (content: string | Record<string, string>) => string;
}

export const ResourceCard = ({ download, hasProfile, onViewPdf, renderContent }: ResourceCardProps) => {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    const getFileTypeIcon = (download: any) => {
        const fileType = download.file_type || '';
        const extension = download.file_extension || '';

        if (fileType.includes('pdf')) {
            return <FileType className="h-8 w-8 text-red-500" />;
        } else if (fileType.includes('image') || extension.includes('jpg') || extension.includes('png')) {
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

    return (
        <div className="group bg-white border border-border rounded-xl p-6 hover:shadow-lg hover:border-primary/20 transition-all duration-200 hover:-translate-y-1">
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
                                onClick={() => onViewPdf(download)}
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
    );
};