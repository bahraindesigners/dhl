import { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Alert, AlertDescription } from '@/components/ui/alert';
import {
    ArrowLeft,
    Banknote,
    Calendar,
    AlertCircle,
    CheckCircle2,
    Info
} from 'lucide-react';

interface AlHasalaSettings {
    max_months: number;
    min_monthly_payment: number;
}

interface CreateAlHasalaProps {
    settings: AlHasalaSettings;
}

export default function CreateAlHasala({ settings }: CreateAlHasalaProps) {
    const { t } = useTranslation();
    const [isSubmitting, setIsSubmitting] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        monthly_amount: '',
        months: '',
        note: '',
    });

    // Calculate total amount
    const totalAmount = data.monthly_amount && data.months ?
        Math.round((parseFloat(data.monthly_amount) * parseInt(data.months)) * 100) / 100 : 0;

    // Check if monthly amount meets minimum requirement
    const isValidMonthlyAmount = data.monthly_amount && parseFloat(data.monthly_amount) >= settings.min_monthly_payment;

    // Check if months is valid
    const isValidMonths = data.months &&
        parseInt(data.months) >= 1 &&
        parseInt(data.months) <= settings.max_months;

    const isFormValid = isValidMonthlyAmount && isValidMonths;

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setIsSubmitting(true);

        post('/al-hasala', {
            onSuccess: () => {
                setIsSubmitting(false);
                // The success will be handled by a redirect to the al-hasala index
            },
            onError: () => {
                setIsSubmitting(false);
            }
        });
    };

    return (
        <NavbarLayout>
            <Head title={t('alHasala.applyForAlHasala')} />

            <div className="container mx-auto px-4 py-8">
                {/* Header */}
                <div className="mb-8">
                    <div className="flex items-center space-x-4 mb-4">
                        <Button variant="outline" size="sm" asChild>
                            <Link href="/al-hasala">
                                <ArrowLeft className="mr-2 h-4 w-4" />
                                {t('common.back')}
                            </Link>
                        </Button>
                    </div>
                    <h1 className="text-3xl font-bold tracking-tight">{t('alHasala.applyForAlHasala')}</h1>
                    <p className="text-muted-foreground mt-2">{t('alHasala.applyDescription')}</p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Application Form */}
                    <div className="lg:col-span-2">
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center space-x-2">
                                    <Banknote className="h-5 w-5" />
                                    <span>{t('alHasala.applicationForm')}</span>
                                </CardTitle>
                                <CardDescription>
                                    {t('alHasala.formDescription')}
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={handleSubmit} className="space-y-6">
                                    {/* Monthly Amount */}
                                    <div className="space-y-2">
                                        <Label htmlFor="monthly_amount">{t('alHasala.monthlyAmount')}</Label>
                                        <div className="relative">
                                            <Input
                                                id="monthly_amount"
                                                type="number"
                                                min={settings.min_monthly_payment}
                                                step="10"
                                                value={data.monthly_amount}
                                                onChange={(e) => setData('monthly_amount', e.target.value)}
                                                placeholder={settings.min_monthly_payment.toString()}
                                                className={`pl-12 ${!isValidMonthlyAmount && data.monthly_amount ? 'border-red-500' : ''}`}
                                                required
                                            />
                                            <div className="absolute inset-y-0 left-0 flex items-center pl-3">
                                                <span className="text-gray-500 text-sm">BD</span>
                                            </div>
                                        </div>
                                        {errors.monthly_amount && (
                                            <p className="text-sm text-red-600">{errors.monthly_amount}</p>
                                        )}
                                        {!isValidMonthlyAmount && data.monthly_amount && !errors.monthly_amount && (
                                            <p className="text-sm text-red-600">
                                                {t('alHasala.monthlyPaymentMinimum', { minPayment: settings.min_monthly_payment })}
                                            </p>
                                        )}
                                        <p className="text-sm text-muted-foreground">
                                            {t('alHasala.minMonthlyPayment', { minPayment: settings.min_monthly_payment })}
                                        </p>
                                    </div>

                                    {/* Duration */}
                                    <div className="space-y-2">
                                        <Label htmlFor="months">{t('alHasala.duration')}</Label>
                                        <div className="relative">
                                            <Input
                                                id="months"
                                                type="number"
                                                min="1"
                                                max={settings.max_months}
                                                value={data.months}
                                                onChange={(e) => setData('months', e.target.value)}
                                                placeholder="1"
                                                className={`pr-16 ${!isValidMonths && data.months ? 'border-red-500' : ''}`}
                                                required
                                            />
                                            <div className="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span className="text-gray-500 text-sm">{t('alHasala.months')}</span>
                                            </div>
                                        </div>
                                        {errors.months && (
                                            <p className="text-sm text-red-600">{errors.months}</p>
                                        )}
                                        {!isValidMonths && data.months && !errors.months && (
                                            <p className="text-sm text-red-600">
                                                {t('alHasala.monthsMaximum', { max: settings.max_months })}
                                            </p>
                                        )}
                                        <p className="text-sm text-muted-foreground">
                                            {t('alHasala.maxMonths', { max: settings.max_months })}
                                        </p>
                                    </div>

                                    {/* Note */}
                                    <div className="space-y-2">
                                        <Label htmlFor="note">{t('alHasala.note')} ({t('common.optional')})</Label>
                                        <Textarea
                                            id="note"
                                            value={data.note}
                                            onChange={(e) => setData('note', e.target.value)}
                                            placeholder={t('alHasala.notePlaceholder')}
                                            rows={4}
                                            maxLength={1000}
                                        />
                                        {errors.note && (
                                            <p className="text-sm text-red-600">{errors.note}</p>
                                        )}
                                        <p className="text-sm text-muted-foreground">
                                            {data.note.length}/1000 {t('common.characters')}
                                        </p>
                                    </div>

                                    {/* Submit Button */}
                                    <div className="flex items-center space-x-4 pt-6">
                                        <Button
                                            type="submit"
                                            disabled={processing || isSubmitting || !isFormValid}
                                            className="flex-1 sm:flex-none"
                                        >
                                            {(processing || isSubmitting) ? (
                                                <>
                                                    <div className="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2" />
                                                    {t('alHasala.submitting')}
                                                </>
                                            ) : (
                                                <>
                                                    <Banknote className="mr-2 h-4 w-4" />
                                                    {t('alHasala.submitApplication')}
                                                </>
                                            )}
                                        </Button>
                                        <Button type="button" variant="outline" asChild>
                                            <Link href="/al-hasala">
                                                {t('common.cancel')}
                                            </Link>
                                        </Button>
                                    </div>
                                </form>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Sidebar Information */}
                    <div className="space-y-6">
                        {/* Al Hasala Calculator Preview */}
                        {data.monthly_amount && data.months && (
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-lg">{t('alHasala.preview')}</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="flex justify-between">
                                        <span className="text-sm text-muted-foreground">{t('alHasala.monthlyAmount')}:</span>
                                        <span className="font-medium">BD {data.monthly_amount}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-sm text-muted-foreground">{t('alHasala.duration')}:</span>
                                        <span className="font-medium">{data.months} {t('alHasala.months')}</span>
                                    </div>
                                    <div className="flex justify-between border-t pt-2">
                                        <span className="text-sm text-muted-foreground">{t('alHasala.totalAmount')}:</span>
                                        <span className="font-medium text-green-600">
                                            BD {totalAmount.toFixed(2)}
                                        </span>
                                    </div>
                                    {isValidMonthlyAmount && isValidMonths && (
                                        <div className="bg-green-50 border border-green-200 rounded-lg p-3">
                                            <p className="text-sm text-green-700">
                                                {t('alHasala.validSavingsPlan')}
                                            </p>
                                        </div>
                                    )}
                                </CardContent>
                            </Card>
                        )}

                        {/* Guidelines */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg flex items-center space-x-2">
                                    <Info className="h-5 w-5" />
                                    <span>{t('alHasala.guidelines')}</span>
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-3">
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">{t('alHasala.requiresMembership')}</span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">
                                        {t('alHasala.minMonthlyPayment', { minPayment: settings.min_monthly_payment })}
                                    </span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">
                                        {t('alHasala.maxMonths', { max: settings.max_months })}
                                    </span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">{t('alHasala.noInterest')}</span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">{t('alHasala.reviewProcess')}</span>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Important Notice */}
                        <Alert>
                            <AlertCircle className="h-4 w-4" />
                            <AlertDescription>
                                {t('alHasala.importantNotice')}
                            </AlertDescription>
                        </Alert>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}