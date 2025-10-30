import { Head, Link, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Alert, AlertDescription } from '@/components/ui/alert';
import {
    Plus,
    Banknote,
    Calendar,
    Clock,
    Eye,
    AlertCircle,
    CheckCircle2,
    XCircle
} from 'lucide-react';

interface AlHasalaApplication {
    id: number;
    amount: string;
    months: number;
    status: 'pending' | 'approved' | 'rejected';
    status_label: string;
    note?: string;
    rejected_reason?: string;
    created_at: string;
    created_at_human: string;
}

interface AlHasalaSettings {
    max_months: number;
    min_amount: number;
    min_monthly_payment: number;
    is_active: boolean;
}

interface MemberProfile {
    staff_number: string;
    position: string;
    department: string;
}

interface AlHasalaIndexProps {
    alHasalas: AlHasalaApplication[];
    settings: AlHasalaSettings | null;
    memberProfile: MemberProfile | null;
}

export default function AlHasalaIndex({ alHasalas, settings, memberProfile }: AlHasalaIndexProps) {
    const { t, i18n } = useTranslation();
    const { flash } = usePage<{ flash: { success?: string; error?: string } }>().props;
    const isRtl = i18n.dir() === 'rtl';
    const getStatusIcon = (status: string) => {
        switch (status) {
            case 'pending':
                return <Clock className="h-4 w-4" />;
            case 'approved':
                return <CheckCircle2 className="h-4 w-4" />;
            case 'rejected':
                return <XCircle className="h-4 w-4" />;
            default:
                return <AlertCircle className="h-4 w-4" />;
        }
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'pending':
                return 'bg-yellow-100 text-yellow-800 border-yellow-200';
            case 'approved':
                return 'bg-green-100 text-green-800 border-green-200';
            case 'rejected':
                return 'bg-red-100 text-red-800 border-red-200';
            default:
                return 'bg-gray-100 text-gray-800 border-gray-200';
        }
    };

    return (
        <NavbarLayout>
            <Head title={t('alHasala.title')} />

            <div className="container mx-auto px-4 py-8 space-y-8" dir={isRtl ? 'rtl' : 'ltr'}>
                {/* Flash Messages */}
                {flash?.success && (
                    <Alert className="bg-green-50 border-green-200 text-green-800">
                        <CheckCircle2 className="h-4 w-4" />
                        <AlertDescription>{flash.success}</AlertDescription>
                    </Alert>
                )}

                {flash?.error && (
                    <Alert className="bg-red-50 border-red-200 text-red-800">
                        <XCircle className="h-4 w-4" />
                        <AlertDescription>{flash.error}</AlertDescription>
                    </Alert>
                )}

                {/* Header Section */}
                <div className="space-y-4">
                    <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 className="text-3xl font-bold tracking-tight">{t('alHasala.title')}</h1>
                            <p className="text-muted-foreground">{t('alHasala.description')}</p>
                        </div>

                        {settings?.is_active ? (
                            <Button asChild size="lg">
                                <Link href="/al-hasala/create">
                                    <Plus className="mr-2 h-4 w-4" />
                                    {t('alHasala.applyNew')}
                                </Link>
                            </Button>
                        ) : (
                            <Badge variant="secondary" className="self-start">
                                <AlertCircle className="mr-2 h-4 w-4" />
                                {t('alHasala.formDisabled')}
                            </Badge>
                        )}
                    </div>

                    {/* Member Profile Info */}
                    {memberProfile && (
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">{t('alHasala.memberInfo')}</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span className="font-medium">{t('profile.staffNumber')}: </span>
                                        <span>{memberProfile.staff_number}</span>
                                    </div>
                                    <div>
                                        <span className="font-medium">{t('profile.position')}: </span>
                                        <span>{memberProfile.position}</span>
                                    </div>
                                    <div>
                                        <span className="font-medium">{t('profile.department')}: </span>
                                        <span>{memberProfile.department}</span>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    )}
                </div>

                {/* Al Hasala Applications */}
                <div className="space-y-6">
                    <div className="flex items-center justify-between">
                        <h2 className="text-2xl font-semibold">{t('alHasala.myApplications')}</h2>
                        <Badge variant="outline">
                            {alHasalas.length} {t('alHasala.applications')}
                        </Badge>
                    </div>

                    {alHasalas.length === 0 ? (
                        <Card>
                            <CardContent className="flex flex-col items-center justify-center py-12">
                                <Banknote className="h-12 w-12 text-muted-foreground mb-4" />
                                <h3 className="text-lg font-semibold mb-2">{t('alHasala.noApplications')}</h3>
                                <p className="text-muted-foreground text-center mb-6">
                                    {t('alHasala.noApplicationsDescription')}
                                </p>
                                {settings?.is_active && (
                                    <Button asChild>
                                        <Link href="/al-hasala/create">
                                            <Plus className="mr-2 h-4 w-4" />
                                            {t('alHasala.applyNow')}
                                        </Link>
                                    </Button>
                                )}
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="grid gap-4">
                            {alHasalas.map((alHasala) => (
                                <Card key={alHasala.id} className="hover:shadow-md transition-shadow">
                                    <CardHeader>
                                        <div className="flex items-center justify-between">
                                            <CardTitle className="text-lg">
                                                {t('alHasala.application')} #{alHasala.id}
                                            </CardTitle>
                                            <Badge
                                                variant="outline"
                                                className={getStatusColor(alHasala.status)}
                                            >
                                                {getStatusIcon(alHasala.status)}
                                                <span className="ml-1">{t(`alHasala.statuses.${alHasala.status.toLowerCase()}`)}</span>
                                            </Badge>
                                        </div>
                                        <CardDescription>
                                            {t('alHasala.appliedOn')} {alHasala.created_at_human}
                                        </CardDescription>
                                    </CardHeader>
                                    <CardContent>
                                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                            <div className="flex items-center space-x-2">
                                                <Banknote className="h-4 w-4 text-muted-foreground" />
                                                <span className="font-medium">
                                                    {alHasala.amount} {t('common.currency')}
                                                </span>
                                            </div>
                                            <div className="flex items-center space-x-2">
                                                <Calendar className="h-4 w-4 text-muted-foreground" />
                                                <span>
                                                    {alHasala.months} {t('alHasala.months')}
                                                </span>
                                            </div>
                                            <div className="flex items-center space-x-2">
                                                <Clock className="h-4 w-4 text-muted-foreground" />
                                                <span className="text-sm text-muted-foreground">
                                                    {alHasala.created_at_human}
                                                </span>
                                            </div>
                                        </div>

                                        {alHasala.note && (
                                            <>
                                                <Separator className="my-4" />
                                                <div>
                                                    <p className="text-sm font-medium mb-1">{t('alHasala.note')}:</p>
                                                    <p className="text-sm text-muted-foreground">{alHasala.note}</p>
                                                </div>
                                            </>
                                        )}

                                        {alHasala.rejected_reason && (
                                            <>
                                                <Separator className="my-4" />
                                                <div className="bg-red-50 border border-red-200 rounded-lg p-3">
                                                    <p className="text-sm font-medium text-red-800 mb-1">
                                                        {t('alHasala.rejectionReason')}:
                                                    </p>
                                                    <p className="text-sm text-red-700">{alHasala.rejected_reason}</p>
                                                </div>
                                            </>
                                        )}

                                        <div className="flex justify-end mt-4">
                                            <Button variant="outline" size="sm" asChild>
                                                <Link href={`/al-hasala/${alHasala.id}`}>
                                                    <Eye className="mr-2 h-4 w-4" />
                                                    {t('alHasala.viewDetails')}
                                                </Link>
                                            </Button>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    )}
                </div>

                {/* Al Hasala Guidelines */}
                {settings && (
                    <Card>
                        <CardHeader>
                            <CardTitle>{t('alHasala.guidelines')}</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-3 text-sm">
                                <div className="flex items-center space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600" />
                                    <span>{t('alHasala.amountRangeGuideline', { min: settings.min_amount })}</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600" />
                                    <span>{t('alHasala.durationRange', { max: settings.max_months })}</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600" />
                                    <span>{t('alHasala.minMonthlyPayment', { minPayment: settings.min_monthly_payment })}</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600" />
                                    <span>{t('alHasala.requiresMembership')}</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600" />
                                    <span>{t('alHasala.reviewProcess')}</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                )}
            </div>
        </NavbarLayout>
    );
}