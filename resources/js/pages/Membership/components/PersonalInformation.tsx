import { useTranslation } from 'react-i18next';

interface PersonalInformationProps {
    data: any;
    setData: (key: string, value: any) => void;
    errors: Record<string, string>;
    isRTL: boolean;
    user?: {
        name: string;
        email: string;
    };
}

export default function PersonalInformation({ data, setData, errors, isRTL, user }: PersonalInformationProps) {
    const { t } = useTranslation();

    return (
        <div className="space-y-6">
            <h3 className={`text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3 ${isRTL ? 'font-arabic text-right' : ''}`}>
                {t('membership.form.personalInformation')}
            </h3>
            
            {/* Display authenticated user info as read-only */}
            <div className="bg-gray-50 p-4 rounded-lg border">
                <h4 className={`text-sm font-medium text-gray-700 mb-3 ${isRTL ? 'font-arabic text-right' : ''}`}>
                    {t('membership.form.authenticatedUserInfo')}
                </h4>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span className={`text-sm text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('membership.form.fullName')}: 
                        </span>
                        <span className={`ml-2 font-medium text-gray-900 ${isRTL ? 'font-arabic mr-2 ml-0' : ''}`}>
                            {user?.name}
                        </span>
                    </div>
                    <div>
                        <span className={`text-sm text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('membership.form.email')}: 
                        </span>
                        <span className={`ml-2 font-medium text-gray-900 ${isRTL ? 'font-arabic mr-2 ml-0' : ''}`}>
                            {user?.email}
                        </span>
                    </div>
                </div>
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label htmlFor="mobile_number" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.mobileNumber')} <span className="text-red-500">*</span>
                    </label>
                    <input
                        type="tel"
                        id="mobile_number"
                        name="mobile_number"
                        value={data.mobile_number}
                        onChange={(e) => setData('mobile_number', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.mobile_number ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.mobileNumberPlaceholder')}
                    />
                    {errors.mobile_number && <p className="mt-1 text-sm text-red-600">{errors.mobile_number}</p>}
                </div>

                <div>
                    <label htmlFor="cpr_number" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.cprNumber')} <span className="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="cpr_number"
                        name="cpr_number"
                        value={data.cpr_number}
                        onChange={(e) => setData('cpr_number', e.target.value)}
                        required
                        maxLength={9}
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.cpr_number ? 'border-red-500' : ''}`}
                        placeholder="123456789"
                    />
                    {errors.cpr_number && <p className="mt-1 text-sm text-red-600">{errors.cpr_number}</p>}
                </div>

                <div>
                    <label htmlFor="nationality" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.nationality')} <span className="text-red-500">*</span>
                    </label>
                    <select
                        id="nationality"
                        name="nationality"
                        value={data.nationality}
                        onChange={(e) => setData('nationality', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.nationality ? 'border-red-500' : ''}`}
                    >
                        <option value="">{t('membership.form.selectNationality')}</option>
                        <option value="Bahraini">Bahraini</option>
                        <option value="Saudi Arabian">Saudi Arabian</option>
                        <option value="Emirati">Emirati</option>
                        <option value="Kuwaiti">Kuwaiti</option>
                        <option value="Qatari">Qatari</option>
                        <option value="Omani">Omani</option>
                        <option value="Other">Other</option>
                    </select>
                    {errors.nationality && <p className="mt-1 text-sm text-red-600">{errors.nationality}</p>}
                </div>

                <div>
                    <label htmlFor="gender" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.gender')} <span className="text-red-500">*</span>
                    </label>
                    <select
                        id="gender"
                        name="gender"
                        value={data.gender}
                        onChange={(e) => setData('gender', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.gender ? 'border-red-500' : ''}`}
                    >
                        <option value="">{t('membership.form.selectGender')}</option>
                        <option value="male">{t('membership.form.male')}</option>
                        <option value="female">{t('membership.form.female')}</option>
                    </select>
                    {errors.gender && <p className="mt-1 text-sm text-red-600">{errors.gender}</p>}
                </div>

                <div>
                    <label htmlFor="marital_status" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.maritalStatus')} <span className="text-red-500">*</span>
                    </label>
                    <select
                        id="marital_status"
                        name="marital_status"
                        value={data.marital_status}
                        onChange={(e) => setData('marital_status', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.marital_status ? 'border-red-500' : ''}`}
                    >
                        <option value="">{t('membership.form.selectMaritalStatus')}</option>
                        <option value="single">{t('membership.form.single')}</option>
                        <option value="married">{t('membership.form.married')}</option>
                        <option value="divorced">{t('membership.form.divorced')}</option>
                        <option value="widow">{t('membership.form.widow')}</option>
                    </select>
                    {errors.marital_status && <p className="mt-1 text-sm text-red-600">{errors.marital_status}</p>}
                </div>
            </div>
        </div>
    );
}