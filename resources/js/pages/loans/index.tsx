import { Head, Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
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

interface LoanApplication {
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

interface LoanSettings {
    max_months: number;
    is_active: boolean;
}

interface MemberProfile {
    staff_number: string;
    position: string;
    department: string;
}

interface LoansIndexProps {
    loans: LoanApplication[];
    settings: LoanSettings | null;
    memberProfile: MemberProfile | null;
}

export default function LoansIndex({ loans, settings, memberProfile }: LoansIndexProps) {
    const { t } = useTranslation();

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
            <Head title={t('loans.title')} />
            
            <div className="container mx-auto px-4 py-8 space-y-8">
                {/* Header Section */}
                <div className="space-y-4">
                    <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 className="text-3xl font-bold tracking-tight">{t('loans.title')}</h1>
                            <p className="text-muted-foreground">{t('loans.description')}</p>
                        </div>
                        
                        {settings?.is_active ? (
                            <Button asChild size="lg">
                                <Link href="/loans/create">
                                    <Plus className="mr-2 h-4 w-4" />
                                    {t('loans.applyNew')}
                                </Link>
                            </Button>
                        ) : (
                            <Badge variant="secondary" className="self-start">
                                <AlertCircle className="mr-2 h-4 w-4" />
                                {t('loans.formDisabled')}
                            </Badge>
                        )}
                    </div>

                    {/* Member Profile Info */}
                    {memberProfile && (
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">{t('loans.memberInfo')}</CardTitle>
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

                {/* Loan Applications */}
                <div className="space-y-6">
                    <div className="flex items-center justify-between">
                        <h2 className="text-2xl font-semibold">{t('loans.myApplications')}</h2>
                        <Badge variant="outline">
                            {loans.length} {t('loans.applications')}
                        </Badge>
                    </div>

                    {loans.length === 0 ? (
                        <Card>
                            <CardContent className="flex flex-col items-center justify-center py-12">
                                <Banknote className="h-12 w-12 text-muted-foreground mb-4" />
                                <h3 className="text-lg font-semibold mb-2">{t('loans.noApplications')}</h3>
                                <p className="text-muted-foreground text-center mb-6">
                                    {t('loans.noApplicationsDescription')}
                                </p>
                                {settings?.is_active && (
                                    <Button asChild>
                                        <Link href="/loans/create">
                                            <Plus className="mr-2 h-4 w-4" />
                                            {t('loans.applyNow')}
                                        </Link>
                                    </Button>
                                )}
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="grid gap-4">
                            {loans.map((loan) => (
                                <Card key={loan.id} className="hover:shadow-md transition-shadow">
                                    <CardHeader>
                                        <div className="flex items-center justify-between">
                                            <CardTitle className="text-lg">
                                                {t('loans.application')} #{loan.id}
                                            </CardTitle>
                                            <Badge 
                                                variant="outline" 
                                                className={getStatusColor(loan.status)}
                                            >
                                                {getStatusIcon(loan.status)}
                                                <span className="ml-1">{loan.status_label}</span>
                                            </Badge>
                                        </div>
                                        <CardDescription>
                                            {t('loans.appliedOn')} {loan.created_at_human}
                                        </CardDescription>
                                    </CardHeader>
                                    <CardContent>
                                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                            <div className="flex items-center space-x-2">
                                                <Banknote className="h-4 w-4 text-muted-foreground" />
                                                <span className="font-medium">
                                                    {loan.amount} {t('common.currency')}
                                                </span>
                                            </div>
                                            <div className="flex items-center space-x-2">
                                                <Calendar className="h-4 w-4 text-muted-foreground" />
                                                <span>
                                                    {loan.months} {t('loans.months')}
                                                </span>
                                            </div>
                                            <div className="flex items-center space-x-2">
                                                <Clock className="h-4 w-4 text-muted-foreground" />
                                                <span className="text-sm text-muted-foreground">
                                                    {loan.created_at_human}
                                                </span>
                                            </div>
                                        </div>

                                        {loan.note && (
                                            <>
                                                <Separator className="my-4" />
                                                <div>
                                                    <p className="text-sm font-medium mb-1">{t('loans.note')}:</p>
                                                    <p className="text-sm text-muted-foreground">{loan.note}</p>
                                                </div>
                                            </>
                                        )}

                                        {loan.rejected_reason && (
                                            <>
                                                <Separator className="my-4" />
                                                <div className="bg-red-50 border border-red-200 rounded-lg p-3">
                                                    <p className="text-sm font-medium text-red-800 mb-1">
                                                        {t('loans.rejectionReason')}:
                                                    </p>
                                                    <p className="text-sm text-red-700">{loan.rejected_reason}</p>
                                                </div>
                                            </>
                                        )}

                                        <div className="flex justify-end mt-4">
                                            <Button variant="outline" size="sm" asChild>
                                                <Link href={`/loans/${loan.id}`}>
                                                    <Eye className="mr-2 h-4 w-4" />
                                                    {t('loans.viewDetails')}
                                                </Link>
                                            </Button>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    )}
                </div>

                {/* Loan Guidelines */}
                {settings && (
                    <Card>
                        <CardHeader>
                            <CardTitle>{t('loans.guidelines')}</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-3 text-sm">
                                <div className="flex items-center space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600" />
                                    <span>{t('loans.maxDuration')}: {settings.max_months} {t('loans.months')}</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600" />
                                    <span>{t('loans.requiresMembership')}</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <CheckCircle2 className="h-4 w-4 text-green-600" />
                                    <span>{t('loans.reviewProcess')}</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                )}
            </div>
        </NavbarLayout>
    );
}