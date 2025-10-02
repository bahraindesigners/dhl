import { Head, Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { 
    Plus, 
    FileText, 
    Clock, 
    CheckCircle, 
    XCircle, 
    AlertCircle,
    Calendar,
    Ticket
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
    complaints: Complaint[];
}

export default function ComplaintsIndex({ complaints }: Props) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    const getStatusIcon = (status: string) => {
        switch (status) {
            case 'pending':
                return <Clock className="h-4 w-4" />;
            case 'in_progress':
                return <AlertCircle className="h-4 w-4" />;
            case 'resolved':
                return <CheckCircle className="h-4 w-4" />;
            case 'closed':
                return <XCircle className="h-4 w-4" />;
            default:
                return <FileText className="h-4 w-4" />;
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
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }).format(date);
    };

    return (
        <NavbarLayout>
            <Head title={t('complaints.myComplaints')} />
            
            <div className="min-h-screen bg-gray-50 py-8">
                <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Page Header */}
                    <div className="mb-8 flex justify-between items-center">
                        <div>
                            <h1 className={`text-3xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                                {t('complaints.myComplaints')}
                            </h1>
                            <p className={`mt-2 text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                {t('complaints.indexDescription')}
                            </p>
                        </div>
                        <Link href="/complaints/create">
                            <Button className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                <Plus className="h-4 w-4" />
                                {t('complaints.newComplaint')}
                            </Button>
                        </Link>
                    </div>

                    {/* No Complaints */}
                    {complaints.length === 0 && (
                        <Card>
                            <CardContent className="flex flex-col items-center justify-center py-12">
                                <FileText className="h-16 w-16 text-gray-400 mb-4" />
                                <h3 className={`text-lg font-medium text-gray-900 mb-2 ${isRTL ? 'font-arabic' : ''}`}>
                                    {t('complaints.noComplaints')}
                                </h3>
                                <p className={`text-gray-500 text-center mb-4 ${isRTL ? 'font-arabic' : ''}`}>
                                    {t('complaints.noComplaintsDescription')}
                                </p>
                                <Link href="/complaints/create">
                                    <Button className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                        <Plus className="h-4 w-4" />
                                        {t('complaints.createFirstComplaint')}
                                    </Button>
                                </Link>
                            </CardContent>
                        </Card>
                    )}

                    {/* Complaints List */}
                    {complaints.length > 0 && (
                        <div className="space-y-4">
                            {complaints.map((complaint) => (
                                <Card key={complaint.id} className="hover:shadow-md transition-shadow">
                                    <CardHeader>
                                        <div className="flex items-start justify-between">
                                            <div className="flex-1">
                                                <div className="flex items-center gap-2 mb-2">
                                                    <Ticket className="h-4 w-4 text-gray-500" />
                                                    <span className={`text-sm font-mono text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                        {complaint.ticket_id}
                                                    </span>
                                                </div>
                                                <CardTitle className={`${isRTL ? 'font-arabic' : ''}`}>
                                                    <Link 
                                                        href={`/complaints/${complaint.id}`}
                                                        className="hover:text-blue-600 transition-colors"
                                                    >
                                                        {complaint.subject}
                                                    </Link>
                                                </CardTitle>
                                                <CardDescription className={`${isRTL ? 'font-arabic' : ''} mt-1`}>
                                                    {complaint.description.length > 150 
                                                        ? complaint.description.substring(0, 150) + '...'
                                                        : complaint.description
                                                    }
                                                </CardDescription>
                                            </div>
                                            <div className="flex flex-col items-end gap-2">
                                                <Badge 
                                                    variant={getStatusColor(complaint.status) as any}
                                                    className="flex items-center gap-1"
                                                >
                                                    {getStatusIcon(complaint.status)}
                                                    {t(`complaints.status${complaint.status.charAt(0).toUpperCase() + complaint.status.slice(1).replace('_', '')}`)}
                                                </Badge>
                                                <Badge 
                                                    variant={getPriorityColor(complaint.priority) as any}
                                                    className={`text-xs ${isRTL ? 'font-arabic' : ''}`}
                                                >
                                                    {t(`complaints.priority${complaint.priority.charAt(0).toUpperCase() + complaint.priority.slice(1)}`)}
                                                </Badge>
                                            </div>
                                        </div>
                                    </CardHeader>
                                    <CardContent>
                                        <div className="flex items-center justify-between text-sm text-gray-500">
                                            <div className={`flex items-center gap-1 ${isRTL ? 'font-arabic' : ''}`}>
                                                <Calendar className="h-4 w-4" />
                                                {t('complaints.created')}: {formatDate(complaint.created_at)}
                                            </div>
                                            {complaint.resolved_at && (
                                                <div className={`flex items-center gap-1 ${isRTL ? 'font-arabic' : ''}`}>
                                                    <CheckCircle className="h-4 w-4" />
                                                    {t('complaints.resolved')}: {formatDate(complaint.resolved_at)}
                                                </div>
                                            )}
                                        </div>
                                        {complaint.admin_notes && (
                                            <Alert className="mt-4">
                                                <AlertCircle className="h-4 w-4" />
                                                <AlertDescription className={`${isRTL ? 'font-arabic' : ''}`}>
                                                    <strong>{t('complaints.adminNotes')}:</strong> {complaint.admin_notes}
                                                </AlertDescription>
                                            </Alert>
                                        )}
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </NavbarLayout>
    );
}