import { useState } from 'react';
import { useTranslation } from 'react-i18next';
import { Upload, X, FileText } from 'lucide-react';

interface AttachmentsProps {
    data: any;
    setData: (key: string, value: any) => void;
    errors: Record<string, string>;
    isRTL: boolean;
}

export default function Attachments({ data, setData, errors, isRTL }: AttachmentsProps) {
    const { t } = useTranslation();
    const [isDragOver, setIsDragOver] = useState(false);

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            setData('withdrawal_letter', file);
        }
    };

    const handleDrop = (e: React.DragEvent<HTMLDivElement>) => {
        e.preventDefault();
        setIsDragOver(false);
        
        const file = e.dataTransfer.files[0];
        if (file) {
            setData('withdrawal_letter', file);
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

    const removeFile = () => {
        setData('withdrawal_letter', null);
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
                {t('membership.form.attachments')}
            </h3>
            
            <div className="space-y-4">
                {/* Previous Union Membership Toggle */}
                <div>
                    <label className={`block text-sm font-medium text-gray-700 mb-3 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.previousUnionMember')}
                    </label>
                    <div className="flex items-center space-x-4">
                        <label className={`flex items-center ${isRTL ? 'flex-row-reverse space-x-reverse' : ''}`}>
                            <input
                                type="radio"
                                name="was_previous_member"
                                value="yes"
                                checked={data.was_previous_member === 'yes'}
                                onChange={(e) => setData('was_previous_member', e.target.value)}
                                className="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2"
                            />
                            <span className={`ml-2 text-sm text-gray-700 ${isRTL ? 'font-arabic mr-2 ml-0' : ''}`}>
                                {t('membership.form.yes')}
                            </span>
                        </label>
                        <label className={`flex items-center ${isRTL ? 'flex-row-reverse space-x-reverse' : ''}`}>
                            <input
                                type="radio"
                                name="was_previous_member"
                                value="no"
                                checked={data.was_previous_member === 'no'}
                                onChange={(e) => setData('was_previous_member', e.target.value)}
                                className="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2"
                            />
                            <span className={`ml-2 text-sm text-gray-700 ${isRTL ? 'font-arabic mr-2 ml-0' : ''}`}>
                                {t('membership.form.no')}
                            </span>
                        </label>
                    </div>
                </div>

                {/* Withdrawal Letter Upload - Only show if was previous member */}
                {data.was_previous_member === 'yes' && (
                    <div>
                        <label className={`block text-sm font-medium text-gray-700 mb-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                            {t('membership.form.withdrawalLetter')} <span className="text-red-500">*</span>
                        </label>
                        <p className={`text-sm text-gray-600 mb-4 ${isRTL ? 'font-arabic text-right' : ''}`}>
                            {t('membership.form.withdrawalLetterDescription')}
                        </p>

                        {!data.withdrawal_letter ? (
                            <div
                                className={`relative border-2 border-dashed rounded-lg p-6 transition-colors ${
                                    isDragOver 
                                        ? 'border-primary bg-primary/5' 
                                        : 'border-gray-300 hover:border-gray-400'
                                } ${errors.withdrawal_letter ? 'border-red-500' : ''}`}
                                onDrop={handleDrop}
                                onDragOver={handleDragOver}
                                onDragLeave={handleDragLeave}
                            >
                                <input
                                    type="file"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    onChange={handleFileChange}
                                    className="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                />
                                <div className={`text-center ${isRTL ? 'font-arabic' : ''}`}>
                                    <Upload className="mx-auto h-12 w-12 text-gray-400" />
                                    <div className="mt-4">
                                        <p className="text-sm font-medium text-gray-900">
                                            {t('membership.form.uploadFile')}
                                        </p>
                                        <p className="text-sm text-gray-500 mt-1">
                                            {t('membership.form.supportedFormats')}
                                        </p>
                                        <p className="text-xs text-gray-400 mt-1">
                                            {t('membership.form.maxFileSize')}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        ) : (
                            <div className="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                <div className={`flex items-center ${isRTL ? 'flex-row-reverse' : ''}`}>
                                    <FileText className={`h-8 w-8 text-gray-400 ${isRTL ? 'ml-3' : 'mr-3'}`} />
                                    <div className={isRTL ? 'text-right' : ''}>
                                        <p className={`text-sm font-medium text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                            {data.withdrawal_letter.name}
                                        </p>
                                        <p className="text-xs text-gray-500">
                                            {formatFileSize(data.withdrawal_letter.size)}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    onClick={removeFile}
                                    className="p-1 text-gray-400 hover:text-red-500 transition-colors"
                                >
                                    <X className="h-5 w-5" />
                                </button>
                            </div>
                        )}

                        {errors.withdrawal_letter && (
                            <p className="mt-1 text-sm text-red-600">{errors.withdrawal_letter}</p>
                        )}
                    </div>
                )}

                {/* Information Box */}
                <div className={`p-4 bg-amber-50 border border-amber-200 rounded-lg ${isRTL ? 'text-right' : ''}`}>
                    <p className={`text-sm text-amber-800 ${isRTL ? 'font-arabic' : ''}`}>
                        <strong>{t('membership.form.importantNote')}:</strong> {t('membership.form.withdrawalLetterNote')}
                    </p>
                </div>
            </div>
        </div>
    );
}