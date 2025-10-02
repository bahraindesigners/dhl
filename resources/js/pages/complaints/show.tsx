import { Head, Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { Separator } from '@/components/ui/separator';
import { 
    ArrowLeft, 
    FileText, 
    Clock, 
    CheckCircle, 
    XCircle, 
    AlertCircle,
    Calendar,
    Ticket,
    User,
    MessageSquare,
    Copy
} from 'lucide-react';

interface Complaint {
    id: number;
    ticket_id: string;
    subject: string;
    description: string;
    status: string;
    priority: string;
    admin_notes: string | null;
    resolved_at: string | null;
    created_at: string;
    updated_at: string;
}

interface Props {
    complaint: Complaint;
}

export default function ShowComplaint({ complaint }: Props) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    const getStatusIcon = (status: string) => {
        switch (status) {
            case 'pending':
                return <Clock className="h-5 w-5" />;
            case 'in_progress':
                return <AlertCircle className="h-5 w-5" />;
            case 'resolved':
                return <CheckCircle className="h-5 w-5" />;
            case 'closed':
                return <XCircle className="h-5 w-5" />;
            default:
                return <FileText className="h-5 w-5" />;
        }
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'pending':
                return 'warning';
            case 'in_progress':
                return 'info';
            case 'resolved':
                return 'success';
            case 'closed':
                return 'secondary';
            default:
                return 'secondary';
        }
    };

    const getPriorityColor = (priority: string) => {
        switch (priority) {
            case 'low':
                return 'success';
            case 'medium':
                return 'warning';
            case 'high':
                return 'destructive';
            case 'urgent':
                return 'destructive';
            default:
                return 'secondary';
        }
    };

    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat(isRTL ? 'ar' : 'en', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }).format(date);
    };

    const copyTicketId = () => {
        navigator.clipboard.writeText(complaint.ticket_id);
        // You could add a toast notification here
    };

    return (
        <NavbarLayout>
            <Head title={`${t('complaints.complaint')} - ${complaint.ticket_id}`} />
            
            <div className="min-h-screen bg-gray-50 py-8">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Page Header */}
                    <div className="mb-8">
                        <Link href="/complaints" className="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 mb-4">
                            <ArrowLeft className="h-4 w-4" />
                            <span className={`${isRTL ? 'font-arabic' : ''}`}>{t('complaints.backToComplaints')}</span>
                        </Link>
                        <div className="flex items-start justify-between">
                            <div>
                                <h1 className={`text-3xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                    {complaint.subject}
                                </h1>
                                <div className="flex items-center gap-2 mt-2">
                                    <Ticket className="h-4 w-4 text-gray-500" />
                                    <span className={`text-sm font-mono text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                        {complaint.ticket_id}
                                    </span>
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        onClick={copyTicketId}
                                        className="h-6 w-6 p-0"
                                    >
                                        <Copy className="h-3 w-3" />
                                    </Button>
                                </div>
                            </div>
                            <div className="flex flex-col gap-2">
                                <Badge 
                                    variant={getStatusColor(complaint.status) as any}
                                    className="flex items-center gap-1"
                                >
                                    {getStatusIcon(complaint.status)}
                                    {t(`complaints.status${complaint.status.charAt(0).toUpperCase() + complaint.status.slice(1).replace('_', '')}`)}
                                </Badge>
                                <Badge 
                                    variant={getPriorityColor(complaint.priority) as any}
                                    className={`${isRTL ? 'font-arabic' : ''}`}
                                >
                                    {t(`complaints.priority${complaint.priority.charAt(0).toUpperCase() + complaint.priority.slice(1)}`)}
                                </Badge>
                            </div>
                        </div>
                    </div>

                    {/* Complaint Details */}
                    <div className="space-y-6">
                        {/* Description */}
                        <Card>
                            <CardHeader>
                                <CardTitle className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                    <MessageSquare className="h-5 w-5" />
                                    {t('complaints.description')}
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className={`prose max-w-none ${isRTL ? 'font-arabic text-right' : ''}`}>
                                    <p className="whitespace-pre-wrap">{complaint.description}</p>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Dates and Timeline */}
                        <Card>
                            <CardHeader>
                                <CardTitle className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                    <Calendar className="h-5 w-5" />
                                    {t('complaints.timeline')}
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="flex items-center justify-between py-2">
                                    <div className={`${isRTL ? 'font-arabic' : ''}`}>
                                        <p className="font-medium">{t('complaints.created')}</p>
                                        <p className="text-sm text-gray-600">{formatDate(complaint.created_at)}</p>
                                    </div>
                                    <CheckCircle className="h-5 w-5 text-green-600" />
                                </div>

                                {complaint.status !== 'pending' && (
                                    <>
                                        <Separator />
                                        <div className="flex items-center justify-between py-2">
                                            <div className={`${isRTL ? 'font-arabic' : ''}`}>
                                                <p className="font-medium">{t('complaints.lastUpdated')}</p>
                                                <p className="text-sm text-gray-600">{formatDate(complaint.updated_at)}</p>
                                            </div>
                                            <AlertCircle className="h-5 w-5 text-blue-600" />
                                        </div>
                                    </>
                                )}

                                {complaint.resolved_at && (
                                    <>
                                        <Separator />
                                        <div className="flex items-center justify-between py-2">
                                            <div className={`${isRTL ? 'font-arabic' : ''}`}>
                                                <p className="font-medium">{t('complaints.resolved')}</p>
                                                <p className="text-sm text-gray-600">{formatDate(complaint.resolved_at)}</p>
                                            </div>
                                            <CheckCircle className="h-5 w-5 text-green-600" />
                                        </div>
                                    </>
                                )}
                            </CardContent>
                        </Card>

                        {/* Admin Notes */}
                        {complaint.admin_notes && (
                            <Card>
                                <CardHeader>
                                    <CardTitle className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                        <User className="h-5 w-5" />
                                        {t('complaints.adminResponse')}
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <Alert>
                                        <AlertCircle className="h-4 w-4" />
                                        <AlertDescription className={`${isRTL ? 'font-arabic' : ''}`}>
                                            {complaint.admin_notes}
                                        </AlertDescription>
                                    </Alert>
                                </CardContent>
                            </Card>
                        )}

                        {/* Status Information */}
                        <Card>
                            <CardHeader>
                                <CardTitle className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                    <FileText className="h-5 w-5" />
                                    {t('complaints.statusInfo')}
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className={`prose max-w-none text-sm text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                    {complaint.status === 'pending' && (
                                        <p>{t('complaints.statusPendingInfo')}</p>
                                    )}
                                    {complaint.status === 'in_progress' && (
                                        <p>{t('complaints.statusInProgressInfo')}</p>
                                    )}
                                    {complaint.status === 'resolved' && (
                                        <p>{t('complaints.statusResolvedInfo')}</p>
                                    )}
                                    {complaint.status === 'closed' && (
                                        <p>{t('complaints.statusClosedInfo')}</p>
                                    )}
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}