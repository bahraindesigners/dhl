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

interface LoanSettings {
    max_months: number;
    min_amount: number;
    max_amount: number;
    min_monthly_payment: number;
}

interface CreateLoanProps {
    settings: LoanSettings;
}

export default function CreateLoan({ settings }: CreateLoanProps) {
    const { t } = useTranslation();
    const [isSubmitting, setIsSubmitting] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        amount: '',
        months: '',
        note: '',
    });

    // Calculate monthly payment
    const monthlyPayment = data.amount && data.months ?
        Math.round((parseFloat(data.amount) / parseInt(data.months)) * 100) / 100 : 0;

    // Check if monthly payment meets minimum requirement
    const isValidMonthlyPayment = monthlyPayment >= settings.min_monthly_payment;

    // Calculate maximum duration for current amount
    const maxDurationForAmount = data.amount ?
        Math.floor(parseFloat(data.amount) / settings.min_monthly_payment) : 0;

    // Calculate suggested duration for minimum payment
    const suggestedDuration = data.amount ?
        Math.ceil(parseFloat(data.amount) / settings.min_monthly_payment) : 0;

    // Validation states
    const isValidAmount = data.amount &&
        parseFloat(data.amount) >= settings.min_amount &&
        parseFloat(data.amount) <= settings.max_amount;

    const isValidDuration = data.months &&
        parseInt(data.months) >= 1 &&
        parseInt(data.months) <= settings.max_months &&
        parseInt(data.months) <= maxDurationForAmount;

    const isFormValid = isValidAmount && isValidDuration && isValidMonthlyPayment;

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setIsSubmitting(true);

        post('/loans', {
            onSuccess: () => {
                setIsSubmitting(false);
                // The success will be handled by a redirect to the loans index
            },
            onError: () => {
                setIsSubmitting(false);
            }
        });
    };

    return (
        <NavbarLayout>
            <Head title={t('loans.applyForLoan')} />

            <div className="container mx-auto px-4 py-8">
                {/* Header */}
                <div className="mb-8">
                    <div className="flex items-center space-x-4 mb-4">
                        <Button variant="outline" size="sm" asChild>
                            <Link href="/loans">
                                <ArrowLeft className="mr-2 h-4 w-4" />
                                {t('common.back')}
                            </Link>
                        </Button>
                    </div>
                    <h1 className="text-3xl font-bold tracking-tight">{t('loans.applyForLoan')}</h1>
                    <p className="text-muted-foreground mt-2">{t('loans.applyDescription')}</p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Application Form */}
                    <div className="lg:col-span-2">
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center space-x-2">
                                    <Banknote className="h-5 w-5" />
                                    <span>{t('loans.applicationForm')}</span>
                                </CardTitle>
                                <CardDescription>
                                    {t('loans.formDescription')}
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={handleSubmit} className="space-y-6">
                                    {/* Amount */}
                                    <div className="space-y-2">
                                        <Label htmlFor="amount">{t('loans.amount')}</Label>
                                        <div className="relative">
                                            <Input
                                                id="amount"
                                                type="number"
                                                min={settings.min_amount}
                                                max={settings.max_amount}
                                                step="1"
                                                value={data.amount}
                                                onChange={(e) => setData('amount', e.target.value)}
                                                placeholder={settings.min_amount.toString()}
                                                className={`pl-12 ${!isValidAmount && data.amount ? 'border-red-500' : ''}`}
                                                required
                                            />
                                            <div className="absolute inset-y-0 left-0 flex items-center pl-3">
                                                <span className="text-gray-500 text-sm">BD</span>
                                            </div>
                                        </div>
                                        {errors.amount && (
                                            <p className="text-sm text-red-600">{errors.amount}</p>
                                        )}
                                        {!isValidAmount && data.amount && !errors.amount && (
                                            <p className="text-sm text-red-600">
                                                {t('loans.amountMustBeBetween', { min: settings.min_amount, max: settings.max_amount })}
                                            </p>
                                        )}
                                        <p className="text-sm text-muted-foreground">
                                            {t('loans.amountRange', { min: settings.min_amount, max: settings.max_amount })}
                                        </p>
                                    </div>

                                    {/* Duration */}
                                    <div className="space-y-2">
                                        <Label htmlFor="months">{t('loans.duration')}</Label>
                                        <div className="relative">
                                            <Input
                                                id="months"
                                                type="number"
                                                min="1"
                                                max={Math.min(settings.max_months, maxDurationForAmount || settings.max_months)}
                                                value={data.months}
                                                onChange={(e) => setData('months', e.target.value)}
                                                placeholder={suggestedDuration.toString()}
                                                className={`pr-16 ${!isValidDuration && data.months ? 'border-red-500' : ''}`}
                                                required
                                            />
                                            <div className="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span className="text-gray-500 text-sm">{t('loans.months')}</span>
                                            </div>
                                        </div>
                                        {errors.months && (
                                            <p className="text-sm text-red-600">{errors.months}</p>
                                        )}
                                        {!isValidDuration && data.months && !errors.months && (
                                            <p className="text-sm text-red-600">
                                                {t('loans.maxDurationForAmount', { duration: maxDurationForAmount })}
                                            </p>
                                        )}
                                        <div className="space-y-1">
                                            <p className="text-sm text-muted-foreground">
                                                {t('loans.maxDuration', { max: settings.max_months })}
                                            </p>
                                            {data.amount && maxDurationForAmount < settings.max_months && (
                                                <p className="text-sm text-amber-600">
                                                    {t('loans.maxDurationWarning', {
                                                        amount: data.amount,
                                                        duration: maxDurationForAmount,
                                                        minPayment: settings.min_monthly_payment
                                                    })}
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    {/* Note */}
                                    <div className="space-y-2">
                                        <Label htmlFor="note">{t('loans.note')} ({t('common.optional')})</Label>
                                        <Textarea
                                            id="note"
                                            value={data.note}
                                            onChange={(e) => setData('note', e.target.value)}
                                            placeholder={t('loans.notePlaceholder')}
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
                                                    {t('loans.submitting')}
                                                </>
                                            ) : (
                                                <>
                                                    <Banknote className="mr-2 h-4 w-4" />
                                                    {t('loans.submitApplication')}
                                                </>
                                            )}
                                        </Button>
                                        <Button type="button" variant="outline" asChild>
                                            <Link href="/loans">
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
                        {/* Loan Calculator Preview */}
                        {data.amount && data.months && (
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-lg">{t('loans.preview')}</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="flex justify-between">
                                        <span className="text-sm text-muted-foreground">{t('loans.loanAmount')}:</span>
                                        <span className="font-medium">BD {data.amount}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-sm text-muted-foreground">{t('loans.duration')}:</span>
                                        <span className="font-medium">{data.months} {t('loans.months')}</span>
                                    </div>
                                    <div className="flex justify-between border-t pt-2">
                                        <span className="text-sm text-muted-foreground">{t('loans.monthlyAmount')}:</span>
                                        <span className={`font-medium ${isValidMonthlyPayment ? 'text-green-600' : 'text-red-600'}`}>
                                            BD {monthlyPayment}
                                        </span>
                                    </div>
                                    {!isValidMonthlyPayment && monthlyPayment > 0 && (
                                        <div className="bg-red-50 border border-red-200 rounded-lg p-3">
                                            <p className="text-sm text-red-700">
                                                {t('loans.monthlyPaymentMinimum', { minPayment: settings.min_monthly_payment })}
                                            </p>
                                            <p className="text-xs text-red-600 mt-1">
                                                {t('loans.suggestedDuration', { duration: suggestedDuration })}
                                            </p>
                                        </div>
                                    )}
                                    {isValidMonthlyPayment && monthlyPayment > 0 && (
                                        <div className="bg-green-50 border border-green-200 rounded-lg p-3">
                                            <p className="text-sm text-green-700">
                                                {t('loans.monthlyPaymentValid')}
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
                                    <span>{t('loans.guidelines')}</span>
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-3">
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">{t('loans.requiresMembership')}</span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">
                                        {t('loans.amountRangeGuideline', { min: settings.min_amount, max: settings.max_amount })}
                                    </span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">
                                        {t('loans.durationRange', { max: settings.max_months })}
                                    </span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">
                                        {t('loans.minMonthlyPayment', { minPayment: settings.min_monthly_payment })}
                                    </span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">{t('loans.noInterest')}</span>
                                </div>
                                <div className="flex items-start space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600 mt-0.5" />
                                    <span className="text-sm">{t('loans.reviewProcess')}</span>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Important Notice */}
                        <Alert>
                            <AlertCircle className="h-4 w-4" />
                            <AlertDescription>
                                {t('loans.importantNotice')}
                            </AlertDescription>
                        </Alert>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}