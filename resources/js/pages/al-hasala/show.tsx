import { Head, Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { 
    ArrowLeft,
    Banknote,
    Calendar,
    User,
    FileText,
    Clock,
    CheckCircle2,
    XCircle,
    AlertCircle,
    CreditCard
} from 'lucide-react';

interface AlHasala {
    id: number;
    amount: number;
    months: number;
    status: 'Pending' | 'Approved' | 'Rejected';
    note?: string;
    rejected_reason?: string;
    created_at: string;
    updated_at: string;
    user: {
        id: number;
        name: string;
        email: string;
    };
    member_profile?: {
        id: number;
        member_number: string;
        full_name: string;
        phone: string;
    };
}

interface ShowAlHasalaProps {
    alHasala: AlHasala;
}

export default function ShowAlHasala({ alHasala }: ShowAlHasalaProps) {
    const { t } = useTranslation();

    const getStatusIcon = (status: string) => {
        switch (status) {
            case 'Pending':
                return <Clock className="h-4 w-4" />;
            case 'Approved':
                return <CheckCircle2 className="h-4 w-4" />;
            case 'Rejected':
                return <XCircle className="h-4 w-4" />;
            default:
                return <AlertCircle className="h-4 w-4" />;
        }
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'Pending':
                return 'bg-yellow-100 text-yellow-800 border-yellow-200';
            case 'Approved':
                return 'bg-green-100 text-green-800 border-green-200';
            case 'Rejected':
                return 'bg-red-100 text-red-800 border-red-200';
            default:
                return 'bg-gray-100 text-gray-800 border-gray-200';
        }
    };

    const monthlyPayment = Math.round((alHasala.amount / alHasala.months) * 100) / 100;

    return (
        <NavbarLayout>
            <Head title={`${t('alHasala.alHasalaDetails')} #${alHasala.id}`} />
            
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
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-3xl font-bold tracking-tight">
                                {t('alHasala.alHasalaApplication')} #{alHasala.id}
                            </h1>
                            <p className="text-muted-foreground mt-2">
                                {t('alHasala.appliedOn')} {new Date(alHasala.created_at).toLocaleDateString()}
                            </p>
                        </div>
                        <Badge 
                            variant="outline" 
                            className={`px-3 py-1 ${getStatusColor(alHasala.status)}`}
                        >
                            <span className="flex items-center space-x-1">
                                {getStatusIcon(alHasala.status)}
                                <span>{t(`alHasala.statuses.${alHasala.status.toLowerCase()}`)}</span>
                            </span>
                        </Badge>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Main Content */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Al Hasala Details */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center space-x-2">
                                    <Banknote className="h-5 w-5" />
                                    <span>{t('alHasala.alHasalaDetails')}</span>
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-2 gap-6">
                                    <div>
                                        <label className="text-sm font-medium text-muted-foreground">
                                            {t('alHasala.amount')}
                                        </label>
                                        <p className="text-2xl font-bold">BD {alHasala.amount.toLocaleString()}</p>
                                    </div>
                                    <div>
                                        <label className="text-sm font-medium text-muted-foreground">
                                            {t('alHasala.duration')}
                                        </label>
                                        <p className="text-2xl font-bold">{alHasala.months} {t('alHasala.months')}</p>
                                    </div>
                                </div>

                                <Separator />

                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div className="flex items-center space-x-3 p-4 bg-blue-50 rounded-lg">
                                        <CreditCard className="h-8 w-8 text-blue-600" />
                                        <div>
                                            <p className="text-sm text-blue-600 font-medium">
                                                {t('alHasala.monthlyPayment')}
                                            </p>
                                            <p className="text-xl font-bold text-blue-900">
                                                BD {monthlyPayment}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="flex items-center space-x-3 p-4 bg-green-50 rounded-lg">
                                        <CheckCircle2 className="h-8 w-8 text-green-600" />
                                        <div>
                                            <p className="text-sm text-green-600 font-medium">
                                                {t('alHasala.totalPayback')}
                                            </p>
                                            <p className="text-xl font-bold text-green-900">
                                                BD {alHasala.amount.toLocaleString()}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Application Note */}
                        {alHasala.note && (
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center space-x-2">
                                        <FileText className="h-5 w-5" />
                                        <span>{t('alHasala.applicationNote')}</span>
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div className="bg-gray-50 p-4 rounded-lg">
                                        <p className="text-gray-700 whitespace-pre-wrap">{alHasala.note}</p>
                                    </div>
                                </CardContent>
                            </Card>
                        )}

                        {/* Rejection Reason */}
                        {alHasala.status === 'Rejected' && alHasala.rejected_reason && (
                            <Card className="border-red-200">
                                <CardHeader>
                                    <CardTitle className="flex items-center space-x-2 text-red-700">
                                        <XCircle className="h-5 w-5" />
                                        <span>{t('alHasala.rejectionReason')}</span>
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div className="bg-red-50 p-4 rounded-lg border border-red-200">
                                        <p className="text-red-800 whitespace-pre-wrap">{alHasala.rejected_reason}</p>
                                    </div>
                                </CardContent>
                            </Card>
                        )}
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Member Information */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center space-x-2">
                                    <User className="h-5 w-5" />
                                    <span>{t('alHasala.memberInfo')}</span>
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div>
                                    <label className="text-sm font-medium text-muted-foreground">
                                        {t('common.name')}
                                    </label>
                                    <p className="font-medium">
                                        {alHasala.member_profile?.full_name || alHasala.user.name}
                                    </p>
                                </div>
                                {alHasala.member_profile && (
                                    <>
                                        <div>
                                            <label className="text-sm font-medium text-muted-foreground">
                                                {t('member.memberNumber')}
                                            </label>
                                            <p className="font-medium">{alHasala.member_profile.member_number}</p>
                                        </div>
                                        <div>
                                            <label className="text-sm font-medium text-muted-foreground">
                                                {t('common.phone')}
                                            </label>
                                            <p className="font-medium">{alHasala.member_profile.phone}</p>
                                        </div>
                                    </>
                                )}
                                <div>
                                    <label className="text-sm font-medium text-muted-foreground">
                                        {t('common.email')}
                                    </label>
                                    <p className="font-medium">{alHasala.user.email}</p>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Application Timeline */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center space-x-2">
                                    <Calendar className="h-5 w-5" />
                                    <span>{t('alHasala.timeline')}</span>
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="flex items-start space-x-3">
                                    <div className="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                                    <div>
                                        <p className="font-medium">{t('alHasala.applicationSubmitted')}</p>
                                        <p className="text-sm text-muted-foreground">
                                            {new Date(alHasala.created_at).toLocaleString()}
                                        </p>
                                    </div>
                                </div>
                                {alHasala.updated_at !== alHasala.created_at && (
                                    <div className="flex items-start space-x-3">
                                        <div className={`w-2 h-2 rounded-full mt-2 ${
                                            alHasala.status === 'Approved' ? 'bg-green-600' : 
                                            alHasala.status === 'Rejected' ? 'bg-red-600' : 
                                            'bg-yellow-600'
                                        }`}></div>
                                        <div>
                                            <p className="font-medium">
                                                {t(`alHasala.statuses.${alHasala.status.toLowerCase()}`)}
                                            </p>
                                            <p className="text-sm text-muted-foreground">
                                                {new Date(alHasala.updated_at).toLocaleString()}
                                            </p>
                                        </div>
                                    </div>
                                )}
                            </CardContent>
                        </Card>

                        {/* Actions */}
                        {alHasala.status === 'Pending' && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>{t('alHasala.actions')}</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-sm text-muted-foreground mb-4">
                                        {t('alHasala.pendingMessage')}
                                    </p>
                                    <Button variant="outline" className="w-full" asChild>
                                        <Link href="/al-hasala">
                                            {t('alHasala.backToAlHasala')}
                                        </Link>
                                    </Button>
                                </CardContent>
                            </Card>
                        )}
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}