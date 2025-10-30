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

                {/* Salary Deduction Authorization */}
                <div className={`p-6 bg-gray-50 border-2 border-gray-300 rounded-lg space-y-4 ${isRTL ? 'text-right' : ''}`}>
                    {/* English Version */}
                    <div className="space-y-3">
                        <h4 className="text-base font-bold text-gray-900">
                            Authorization for Salary Deduction - DHL Bahraini Trade Union Workers Membership
                        </h4>
                        <p className="text-sm text-gray-700 leading-relaxed">
                            In accordance with the completed application form for my membership with the DHL Bahraini Trade Union Workers, I hereby authorize DHL Bahrain Company to deduct the following amounts from my salary account:
                        </p>
                        <div className="pl-4 space-y-2">
                            <p className="text-sm font-semibold text-gray-800">Joining Fee:</p>
                            <ul className="list-disc list-inside space-y-1 text-sm text-gray-700">
                                <li>A one-time payment of 2 BHD</li>
                                <li>A recurring monthly payment of 6 BHD</li>
                            </ul>
                        </div>
                    </div>

                    {/* Divider */}
                    <div className="border-t border-gray-300 my-4"></div>

                    {/* Arabic Version */}
                    <div className="space-y-3 font-arabic">
                        <h4 className="text-base font-bold text-gray-900">
                            تفويض خصم الراتب - عضوية نقابة عمال دي إتش إل البحرينية
                        </h4>
                        <p className="text-sm text-gray-700 leading-relaxed">
                            بالتوافق مع استمارة الطلب المكتملة لعضويتي في نقابة عمال دي إتش إل البحرينية، أفوض بموجب هذه الوثيقة شركة دي إتش إل البحرين بخصم المبالغ التالية من حساب راتبي:
                        </p>
                        <div className="pr-4 space-y-2">
                            <p className="text-sm font-semibold text-gray-800">رسوم الانضمام:</p>
                            <ul className="list-disc list-inside space-y-1 text-sm text-gray-700">
                                <li>دفعة واحدة قدرها 2 دينار بحريني</li>
                                <li>دفعة شهرية متكررة قدرها 6 دينار بحريني</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}