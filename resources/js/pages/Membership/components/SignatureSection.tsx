import { useRef, useEffect, useCallback } from 'react';
import { useTranslation } from 'react-i18next';
import SignatureCanvas from 'react-signature-canvas';

interface SignatureSectionProps {
    data: any;
    setData: (key: string, value: any) => void;
    errors: Record<string, string>;
    isRTL: boolean;
}

export default function SignatureSection({ data, setData, errors, isRTL }: SignatureSectionProps) {
    const { t } = useTranslation();
    const signatureRef = useRef<SignatureCanvas>(null);

    const clearSignature = () => {
        signatureRef.current?.clear();
        setData('signature', null);
    };

    const saveSignature = () => {
        if (signatureRef.current) {
            const canvas = signatureRef.current.getCanvas();
            canvas.toBlob((blob) => {
                if (blob) {
                    const file = new File([blob], 'signature.png', { type: 'image/png' });
                    setData('signature', file);
                }
            }, 'image/png');
        }
    };

    // Function to resize canvas properly
    const resizeCanvas = useCallback(() => {
        if (signatureRef.current) {
            const canvas = signatureRef.current.getCanvas();
            const container = canvas.parentElement;
            if (container) {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = container.offsetWidth * ratio;
                canvas.height = container.offsetHeight * ratio;
                canvas.getContext('2d')?.scale(ratio, ratio);
                canvas.style.width = container.offsetWidth + 'px';
                canvas.style.height = container.offsetHeight + 'px';
                signatureRef.current.clear(); // Clear after resize to avoid artifacts
            }
        }
    }, []);

    // Set up proper canvas sizing
    useEffect(() => {
        const timer = setTimeout(() => {
            resizeCanvas();
        }, 100); // Small delay to ensure DOM is ready

        window.addEventListener('resize', resizeCanvas);
        
        return () => {
            clearTimeout(timer);
            window.removeEventListener('resize', resizeCanvas);
        };
    }, [resizeCanvas]);

    return (
        <div className="space-y-6">
            <h3 className={`text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3 ${isRTL ? 'font-arabic text-right' : ''}`}>
                {t('membership.form.digitalSignature')}
            </h3>
            
            <div className="space-y-4">
                <div>
                    <label className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.signatureLabel')} <span className="text-red-500">*</span>
                    </label>
                    <p className={`text-sm text-gray-600 mb-4 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.signatureInstruction')}
                    </p>
                    
                    <div className="border-2 border-gray-300 rounded-lg p-4 bg-white">
                        <div className="w-full h-48 relative">
                            <SignatureCanvas
                                ref={signatureRef}
                                canvasProps={{
                                    className: 'absolute inset-0 w-full h-full border border-gray-200 rounded cursor-crosshair'
                                }}
                                backgroundColor="rgba(255,255,255,1)"
                                penColor="black"
                                minWidth={1}
                                maxWidth={3}
                                onEnd={saveSignature}
                            />
                        </div>
                    </div>
                    
                    <div className="flex gap-3 mt-3">
                        <button
                            type="button"
                            onClick={clearSignature}
                            className={`px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors ${isRTL ? 'font-arabic' : ''}`}
                        >
                            {t('membership.form.clearSignature')}
                        </button>
                        
                        {data.signature && (
                            <span className={`inline-flex items-center px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full ${isRTL ? 'font-arabic' : ''}`}>
                                {t('membership.form.signatureSaved')}
                            </span>
                        )}
                    </div>
                    
                    {errors.signature && <p className="mt-1 text-sm text-red-600">{errors.signature}</p>}
                </div>
                
                <div className={`p-4 bg-blue-50 border border-blue-200 rounded-lg ${isRTL ? 'text-right' : ''}`}>
                    <p className={`text-sm text-blue-800 ${isRTL ? 'font-arabic' : ''}`}>
                        <strong>{t('membership.form.signatureNote')}:</strong> {t('membership.form.signatureNoteText')}
                    </p>
                </div>
            </div>
        </div>
    );
}