import { useTranslation } from 'react-i18next';

interface ContactInformationProps {
    data: any;
    setData: (key: string, value: any) => void;
    errors: Record<string, string>;
    isRTL: boolean;
}

export default function ContactInformation({ data, setData, errors, isRTL }: ContactInformationProps) {
    const { t } = useTranslation();

    return (
        <div className="space-y-6">
            <h3 className={`text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3 ${isRTL ? 'font-arabic text-right' : ''}`}>
                {t('membership.form.contactInformation')}
            </h3>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label htmlFor="office_phone" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.officePhone')}
                    </label>
                    <input
                        type="tel"
                        id="office_phone"
                        name="office_phone"
                        value={data.office_phone}
                        onChange={(e) => setData('office_phone', e.target.value)}
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.office_phone ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.officePhonePlaceholder')}
                    />
                    {errors.office_phone && <p className="mt-1 text-sm text-red-600">{errors.office_phone}</p>}
                </div>

                <div>
                    <label htmlFor="home_phone" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.homePhone')}
                    </label>
                    <input
                        type="tel"
                        id="home_phone"
                        name="home_phone"
                        value={data.home_phone}
                        onChange={(e) => setData('home_phone', e.target.value)}
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.home_phone ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.homePhonePlaceholder')}
                    />
                    {errors.home_phone && <p className="mt-1 text-sm text-red-600">{errors.home_phone}</p>}
                </div>

                <div className="md:col-span-2">
                    <label htmlFor="permanent_address" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.permanentAddress')} <span className="text-red-500">*</span>
                    </label>
                    <textarea
                        id="permanent_address"
                        name="permanent_address"
                        value={data.permanent_address}
                        onChange={(e) => setData('permanent_address', e.target.value)}
                        required
                        rows={3}
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-none ${isRTL ? 'text-right font-arabic' : ''} ${errors.permanent_address ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.permanentAddressPlaceholder')}
                    />
                    {errors.permanent_address && <p className="mt-1 text-sm text-red-600">{errors.permanent_address}</p>}
                </div>

                <div className="md:col-span-2">
                    <label htmlFor="message" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.message')}
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        value={data.message}
                        onChange={(e) => setData('message', e.target.value)}
                        rows={4}
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-none ${isRTL ? 'text-right font-arabic' : ''} ${errors.message ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.messagePlaceholder')}
                    />
                    {errors.message && <p className="mt-1 text-sm text-red-600">{errors.message}</p>}
                </div>
            </div>
        </div>
    );
}