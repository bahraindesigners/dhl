import { useTranslation } from 'react-i18next';
import { useState } from 'react';
import { Upload, X, User } from 'lucide-react';

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
    const [isDragOver, setIsDragOver] = useState(false);

    const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            setData('employee_image', file);
        }
    };

    const handleImageDrop = (e: React.DragEvent<HTMLDivElement>) => {
        e.preventDefault();
        setIsDragOver(false);

        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            setData('employee_image', file);
        }
    };

    const handleDragOver = (e: React.DragEvent<HTMLDivElement>) => {
        e.preventDefault();
        setIsDragOver(true);
    };

    const handleDragLeave = (e: React.DragEvent<HTMLDivElement>) => {
        e.preventDefault();
        setIsDragOver(false);
    };

    const removeImage = () => {
        setData('employee_image', null);
    };

    const formatFileSize = (bytes: number) => {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    };

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
                    <input
                        type="text"
                        id="nationality"
                        name="nationality"
                        value={data.nationality}
                        onChange={(e) => setData('nationality', e.target.value)}
                        required
                        maxLength={50}
                        className={`w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors ${isRTL ? 'text-right font-arabic' : ''} ${errors.nationality ? 'border-red-500' : ''}`}
                        placeholder={t('membership.form.nationalityPlaceholder')}
                    />
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

            {/* Employee Image Upload - Required */}
            <div className="bg-blue-50 border-2 border-blue-200 p-4 rounded-lg">
                <label className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                    {t('membership.form.employeeImage') || 'Employee Image'} <span className="text-red-500">*</span>
                </label>
                <p className={`text-sm text-gray-600 mb-4 ${isRTL ? 'font-arabic text-right' : ''}`}>
                    {t('membership.form.employeeImageDescription') || 'Upload a clear photo of yourself for your membership profile'}
                </p>

                {!data.employee_image ? (
                    <div
                        className={`relative border-2 border-dashed rounded-lg p-6 transition-colors ${isDragOver
                            ? 'border-primary bg-primary/5'
                            : 'border-gray-300 hover:border-gray-400'
                            } ${errors.employee_image ? 'border-red-500' : ''}`}
                        onDrop={handleImageDrop}
                        onDragOver={handleDragOver}
                        onDragLeave={handleDragLeave}
                    >
                        <input
                            type="file"
                            accept="image/*"
                            onChange={handleImageChange}
                            className="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            required
                        />
                        <div className={`text-center ${isRTL ? 'font-arabic' : ''}`}>
                            <User className="mx-auto h-12 w-12 text-gray-400" />
                            <div className="mt-4">
                                <p className="text-sm font-medium text-gray-900">
                                    {t('membership.form.uploadEmployeeImage') || 'Upload Employee Image'}
                                </p>
                                <p className="text-sm text-gray-500 mt-1">
                                    {t('membership.form.imageFormats') || 'Supported formats: JPG, PNG, GIF'}
                                </p>
                                <p className="text-xs text-gray-400 mt-1">
                                    {t('membership.form.maxImageSize') || 'Maximum file size: 10MB'}
                                </p>
                            </div>
                        </div>
                    </div>
                ) : (
                    <div className="space-y-4">
                        {/* Image Preview */}
                        <div className="flex items-center space-x-4">
                            <div className="relative">
                                <img
                                    src={URL.createObjectURL(data.employee_image)}
                                    alt="Employee"
                                    className="w-24 h-24 object-cover rounded-lg border border-gray-200"
                                />
                                <button
                                    type="button"
                                    onClick={removeImage}
                                    className="absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors"
                                >
                                    <X className="h-4 w-4" />
                                </button>
                            </div>
                            <div className={isRTL ? 'text-right' : ''}>
                                <p className={`text-sm font-medium text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                    {data.employee_image.name}
                                </p>
                                <p className="text-xs text-gray-500">
                                    {formatFileSize(data.employee_image.size)}
                                </p>
                            </div>
                        </div>
                    </div>
                )}

                {errors.employee_image && (
                    <p className="mt-1 text-sm text-red-600">{errors.employee_image}</p>
                )}
            </div>
        </div>
    );
}