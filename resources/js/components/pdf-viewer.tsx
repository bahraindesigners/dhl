import React, { useState } from 'react';
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { X, Download, ZoomIn, ZoomOut, Maximize2 } from 'lucide-react';
import { useTranslation } from 'react-i18next';

interface PDFViewerProps {
    isOpen: boolean;
    onClose: () => void;
    pdfUrl: string;
    title: string;
    downloadUrl?: string;
}

export function PDFViewer({ isOpen, onClose, pdfUrl, title, downloadUrl }: PDFViewerProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';
    const [zoom, setZoom] = useState(100);
    const [isFullscreen, setIsFullscreen] = useState(false);

    const handleZoomIn = () => {
        setZoom(prev => Math.min(prev + 25, 200));
    };

    const handleZoomOut = () => {
        setZoom(prev => Math.max(prev - 25, 50));
    };

    const handleDownload = () => {
        if (downloadUrl) {
            window.open(downloadUrl, '_blank');
        }
    };

    const toggleFullscreen = () => {
        setIsFullscreen(prev => !prev);
    };

    return (
        <Dialog open={isOpen} onOpenChange={onClose}>
            <DialogContent 
                className="max-w-none w-[98vw] h-[98vh] p-0"
                style={{
                    maxWidth: isFullscreen ? '100vw' : '98vw',
                    width: isFullscreen ? '100vw' : '98vw',
                    height: isFullscreen ? '100vh' : '98vh',
                }}
            >
                <DialogHeader className="px-4 py-3 border-b bg-background/95 backdrop-blur-sm sticky top-0 z-10">
                    <div className={`flex items-center justify-between gap-4 ${isRTL ? 'flex-row-reverse' : ''}`}>
                        <DialogTitle className={`text-lg font-semibold truncate flex-1 ${isRTL ? 'font-arabic text-right' : ''}`}>
                            {title}
                        </DialogTitle>
                        
                        <div className={`flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
                            <div className="flex items-center gap-1 bg-muted rounded-md p-1">
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    onClick={handleZoomOut}
                                    disabled={zoom <= 50}
                                    className="h-8 w-8 p-0"
                                >
                                    <ZoomOut className="h-4 w-4" />
                                </Button>
                                <span className="text-sm font-medium px-2 min-w-[3rem] text-center">
                                    {zoom}%
                                </span>
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    onClick={handleZoomIn}
                                    disabled={zoom >= 200}
                                    className="h-8 w-8 p-0"
                                >
                                    <ZoomIn className="h-4 w-4" />
                                </Button>
                            </div>

                            <Button
                                variant="ghost"
                                size="sm"
                                onClick={toggleFullscreen}
                                className="h-8 w-8 p-0"
                            >
                                <Maximize2 className="h-4 w-4" />
                            </Button>

                            {downloadUrl && (
                                <Button
                                    variant="outline"
                                    size="sm"
                                    onClick={handleDownload}
                                    className="h-8"
                                >
                                    <Download className="h-4 w-4 mr-1" />
                                    {t('resources.download') || 'Download'}
                                </Button>
                            )}

                            <Button
                                variant="ghost"
                                size="sm"
                                onClick={onClose}
                                className="h-8 w-8 p-0"
                            >
                                <X className="h-4 w-4" />
                            </Button>
                        </div>
                    </div>
                </DialogHeader>

                <div className="flex-1 overflow-hidden bg-gray-100">
                    <div className="h-full w-full overflow-auto">
                        <div className="flex justify-center p-1">
                            <iframe
                                src={`${pdfUrl}#zoom=${zoom}`}
                                className="w-full border-0 bg-white shadow-lg"
                                style={{ 
                                    height: isFullscreen ? 'calc(100vh - 80px)' : 'calc(98vh - 80px)',
                                    minHeight: '750px'
                                }}
                                title={title}
                            />
                        </div>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    );
}
