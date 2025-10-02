import { Head, useForm } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { AlertCircle, Send } from 'lucide-react';

interface FormData {
    subject: string;
    description: string;
    priority: string;
}

export default function CreateComplaint() {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    const { data, setData, post, processing, errors, reset } = useForm<FormData>({
        subject: '',
        description: '',
        priority: 'medium',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        post('/complaints', {
            onSuccess: () => {
                reset();
            },
        });
    };

    return (
        <NavbarLayout>
            <Head title={t('complaints.createComplaint')} />
            
            <div className="min-h-screen bg-gray-50 py-8">
                <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Page Header */}
                    <div className="mb-8">
                        <h1 className={`text-3xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('complaints.createComplaint')}
                        </h1>
                        <p className={`mt-2 text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('complaints.createDescription')}
                        </p>
                    </div>

                    <Card>
                        <CardHeader>
                            <CardTitle className={`${isRTL ? 'font-arabic' : ''}`}>
                                {t('complaints.complaintForm')}
                            </CardTitle>
                            <CardDescription className={`${isRTL ? 'font-arabic' : ''}`}>
                                {t('complaints.formDescription')}
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <form onSubmit={handleSubmit} className="space-y-6">
                                {/* Subject */}
                                <div className="space-y-2">
                                    <Label htmlFor="subject" className={`${isRTL ? 'font-arabic' : ''}`}>
                                        {t('complaints.subject')} <span className="text-red-500">*</span>
                                    </Label>
                                    <Input
                                        id="subject"
                                        type="text"
                                        value={data.subject}
                                        onChange={(e) => setData('subject', e.target.value)}
                                        placeholder={t('complaints.subjectPlaceholder')}
                                        className={`${isRTL ? 'text-right font-arabic' : ''} ${errors.subject ? 'border-red-500' : ''}`}
                                        dir={isRTL ? 'rtl' : 'ltr'}
                                    />
                                    {errors.subject && (
                                        <Alert variant="destructive">
                                            <AlertCircle className="h-4 w-4" />
                                            <AlertDescription>{errors.subject}</AlertDescription>
                                        </Alert>
                                    )}
                                </div>

                                {/* Priority */}
                                <div className="space-y-2">
                                    <Label htmlFor="priority" className={`${isRTL ? 'font-arabic' : ''}`}>
                                        {t('complaints.priority')} <span className="text-red-500">*</span>
                                    </Label>
                                    <Select value={data.priority} onValueChange={(value) => setData('priority', value)}>
                                        <SelectTrigger className={`${isRTL ? 'font-arabic' : ''}`}>
                                            <SelectValue placeholder={t('complaints.selectPriority')} />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="low" className={`${isRTL ? 'font-arabic' : ''}`}>
                                                {t('complaints.priorityLow')}
                                            </SelectItem>
                                            <SelectItem value="medium" className={`${isRTL ? 'font-arabic' : ''}`}>
                                                {t('complaints.priorityMedium')}
                                            </SelectItem>
                                            <SelectItem value="high" className={`${isRTL ? 'font-arabic' : ''}`}>
                                                {t('complaints.priorityHigh')}
                                            </SelectItem>
                                            <SelectItem value="urgent" className={`${isRTL ? 'font-arabic' : ''}`}>
                                                {t('complaints.priorityUrgent')}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                    {errors.priority && (
                                        <Alert variant="destructive">
                                            <AlertCircle className="h-4 w-4" />
                                            <AlertDescription>{errors.priority}</AlertDescription>
                                        </Alert>
                                    )}
                                </div>

                                {/* Description */}
                                <div className="space-y-2">
                                    <Label htmlFor="description" className={`${isRTL ? 'font-arabic' : ''}`}>
                                        {t('complaints.description')} <span className="text-red-500">*</span>
                                    </Label>
                                    <Textarea
                                        id="description"
                                        value={data.description}
                                        onChange={(e) => setData('description', e.target.value)}
                                        placeholder={t('complaints.descriptionPlaceholder')}
                                        rows={6}
                                        className={`${isRTL ? 'text-right font-arabic' : ''} ${errors.description ? 'border-red-500' : ''}`}
                                        dir={isRTL ? 'rtl' : 'ltr'}
                                    />
                                    {errors.description && (
                                        <Alert variant="destructive">
                                            <AlertCircle className="h-4 w-4" />
                                            <AlertDescription>{errors.description}</AlertDescription>
                                        </Alert>
                                    )}
                                    <p className={`text-sm text-gray-500 ${isRTL ? 'font-arabic' : ''}`}>
                                        {t('complaints.descriptionHelp')}
                                    </p>
                                </div>

                                {/* Submit Button */}
                                <div className="flex justify-end pt-4">
                                    <Button
                                        type="submit"
                                        disabled={processing}
                                        className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}
                                    >
                                        <Send className="h-4 w-4" />
                                        {processing ? t('complaints.submitting') : t('complaints.submitComplaint')}
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>

                    {/* Guidelines */}
                    <Card className="mt-6">
                        <CardHeader>
                            <CardTitle className={`${isRTL ? 'font-arabic' : ''}`}>
                                {t('complaints.guidelines')}
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <ul className={`space-y-2 text-sm text-gray-600 ${isRTL ? 'font-arabic list-disc mr-4' : 'list-disc ml-4'}`}>
                                <li>{t('complaints.guideline1')}</li>
                                <li>{t('complaints.guideline2')}</li>
                                <li>{t('complaints.guideline3')}</li>
                                <li>{t('complaints.guideline4')}</li>
                            </ul>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </NavbarLayout>
    );
}