import { useRef } from 'react';
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
        setData('signature', '');
    };

    const saveSignature = () => {
        if (signatureRef.current) {
            const signatureData = signatureRef.current.toDataURL();
            setData('signature', signatureData);
        }
    };

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
                        <SignatureCanvas
                            ref={signatureRef}
                            canvasProps={{
                                width: 600,
                                height: 200,
                                className: 'signature-canvas w-full h-48 border border-gray-200 rounded'
                            }}
                            onEnd={saveSignature}
                        />
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