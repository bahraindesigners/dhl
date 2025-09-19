import { useTranslation } from 'react-i18next';

interface EmploymentInformationProps {
    data: any;
    setData: (key: string, value: any) => void;
    errors: Record<string, string>;
    isRTL: boolean;
}

export default function EmploymentInformation({ data, setData, errors, isRTL }: EmploymentInformationProps) {
    const { t } = useTranslation();

    return (
        <div className="space-y-6">
            <h3 className={`text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3 ${isRTL ? 'font-arabic text-right' : ''}`}>
                {t('membership.form.employmentInformation')}
            </h3>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label htmlFor="staff_number" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.staffNumber')} <span className="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="staff_number"
                        name="staff_number"
                        value={data.staff_number}
                        onChange={(e) => setData('staff_number', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.staff_number ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.staffNumberPlaceholder')}
                    />
                    {errors.staff_number && <p className="mt-1 text-sm text-red-600">{errors.staff_number}</p>}
                </div>

                <div>
                    <label htmlFor="date_of_joining" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.dateOfJoining')} <span className="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="date_of_joining"
                        name="date_of_joining"
                        value={data.date_of_joining}
                        onChange={(e) => setData('date_of_joining', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.date_of_joining ? 'border-red-500' : ''}`}
                    />
                    {errors.date_of_joining && <p className="mt-1 text-sm text-red-600">{errors.date_of_joining}</p>}
                </div>

                <div>
                    <label htmlFor="position" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.position')} <span className="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="position"
                        name="position"
                        value={data.position}
                        onChange={(e) => setData('position', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.position ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.positionPlaceholder')}
                    />
                    {errors.position && <p className="mt-1 text-sm text-red-600">{errors.position}</p>}
                </div>

                <div>
                    <label htmlFor="department" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.department')} <span className="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="department"
                        name="department"
                        value={data.department}
                        onChange={(e) => setData('department', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.department ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.departmentPlaceholder')}
                    />
                    {errors.department && <p className="mt-1 text-sm text-red-600">{errors.department}</p>}
                </div>

                <div>
                    <label htmlFor="section" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.section')} <span className="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="section"
                        name="section"
                        value={data.section}
                        onChange={(e) => setData('section', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.section ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.sectionPlaceholder')}
                    />
                    {errors.section && <p className="mt-1 text-sm text-red-600">{errors.section}</p>}
                </div>

                <div>
                    <label htmlFor="education_qualification" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.educationQualification')} <span className="text-red-500">*</span>
                    </label>
                    <select
                        id="education_qualification"
                        name="education_qualification"
                        value={data.education_qualification}
                        onChange={(e) => setData('education_qualification', e.target.value)}
                        required
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.education_qualification ? 'border-red-500' : ''}`}
                    >
                        <option value="">{t('membership.form.selectEducation')}</option>
                        <option value="High School">High School</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Bachelors Degree">Bachelors Degree</option>
                        <option value="Masters Degree">Masters Degree</option>
                        <option value="PhD">PhD</option>
                        <option value="Other">Other</option>
                    </select>
                    {errors.education_qualification && <p className="mt-1 text-sm text-red-600">{errors.education_qualification}</p>}
                </div>

                <div className="md:col-span-2">
                    <label htmlFor="working_place_address" className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.workingPlaceAddress')} <span className="text-red-500">*</span>
                    </label>
                    <textarea
                        id="working_place_address"
                        name="working_place_address"
                        value={data.working_place_address}
                        onChange={(e) => setData('working_place_address', e.target.value)}
                        required
                        rows={3}
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-none ${isRTL ? 'text-right font-arabic' : ''} ${errors.working_place_address ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.workingPlaceAddressPlaceholder')}
                    />
                    {errors.working_place_address && <p className="mt-1 text-sm text-red-600">{errors.working_place_address}</p>}
                </div>
            </div>
        </div>
    );
}