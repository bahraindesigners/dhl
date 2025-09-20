import { Head, Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { 
    User, 
    Mail, 
    Calendar, 
    Phone, 
    MapPin, 
    Building, 
    Briefcase, 
    GraduationCap,
    Users,
    Edit,
    CheckCircle,
    XCircle
} from 'lucide-react';

interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
}

interface MemberProfile {
    id: number;
    cpr_number: string;
    staff_number: string;
    nationality: string;
    gender: string;
    marital_status: string;
    date_of_joining: string | null;
    position: string;
    department: string;
    section: string;
    working_place_address: string;
    office_phone: string;
    education_qualification: string;
    mobile_number: string;
    home_phone: string;
    permanent_address: string;
    profile_status: boolean;
    created_at: string;
    updated_at: string;
}

interface Props {
    user: User;
    memberProfile: MemberProfile | null;
}

export default function Profile({ user, memberProfile }: Props) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString(i18n.language === 'ar' ? 'ar-BH' : 'en-GB', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    };

    return (
        <NavbarLayout>
            <Head title={t('auth.profile')} />
            
            <div className="min-h-screen bg-gray-50 py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Page Header */}
                    <div className="mb-8">
                        <h1 className={`text-3xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('auth.profile')}
                        </h1>
                        <p className={`mt-2 text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('profile.pageDescription')}
                        </p>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* User Information Card */}
                        <div className="lg:col-span-1">
                            <Card>
                                <CardHeader className="text-center">
                                    <div className="mx-auto h-24 w-24 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                                        <User className="h-12 w-12 text-primary" />
                                    </div>
                                    <CardTitle className={`text-xl ${isRTL ? 'font-arabic' : ''}`}>
                                        {user.name}
                                    </CardTitle>
                                    <CardDescription className="flex items-center justify-center gap-2">
                                        <Mail className="h-4 w-4" />
                                        {user.email}
                                    </CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="flex items-center justify-between">
                                        <span className={`text-sm text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                            {t('profile.emailVerified')}
                                        </span>
                                        {user.email_verified_at ? (
                                            <Badge variant="default" className="flex items-center gap-1">
                                                <CheckCircle className="h-3 w-3" />
                                                {t('common.yes')}
                                            </Badge>
                                        ) : (
                                            <Badge variant="destructive" className="flex items-center gap-1">
                                                <XCircle className="h-3 w-3" />
                                                {t('common.no')}
                                            </Badge>
                                        )}
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <span className={`text-sm text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                            {t('profile.memberSince')}
                                        </span>
                                        <span className={`text-sm ${isRTL ? 'font-arabic' : ''}`}>
                                            {formatDate(user.created_at)}
                                        </span>
                                    </div>
                                    
                                    <Separator />
                                    
                                    <div className="space-y-2">
                                        <Button asChild variant="outline" className="w-full">
                                            <Link href="/settings/profile">
                                                <Edit className="h-4 w-4 mr-2" />
                                                {t('profile.editProfile')}
                                            </Link>
                                        </Button>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        {/* Member Profile Information */}
                        <div className="lg:col-span-2">
                            {memberProfile ? (
                                <div className="space-y-6">
                                    {/* Profile Status */}
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                <Users className="h-5 w-5" />
                                                {t('profile.membershipStatus')}
                                            </CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="flex items-center gap-2">
                                                {memberProfile.profile_status ? (
                                                    <Badge variant="default" className="flex items-center gap-1">
                                                        <CheckCircle className="h-3 w-3" />
                                                        {t('profile.active')}
                                                    </Badge>
                                                ) : (
                                                    <Badge variant="secondary" className="flex items-center gap-1">
                                                        <XCircle className="h-3 w-3" />
                                                        {t('profile.pending')}
                                                    </Badge>
                                                )}
                                            </div>
                                        </CardContent>
                                    </Card>

                                    {/* Personal Information */}
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className={`${isRTL ? 'font-arabic' : ''}`}>
                                                {t('profile.personalInformation')}
                                            </CardTitle>
                                        </CardHeader>
                                        <CardContent className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.cprNumber')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.cpr_number}</p>
                                            </div>
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.nationality')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.nationality}</p>
                                            </div>
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.gender')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t(`membership.form.${memberProfile.gender}`)}
                                                </p>
                                            </div>
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.maritalStatus')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t(`membership.form.${memberProfile.marital_status}`)}
                                                </p>
                                            </div>
                                        </CardContent>
                                    </Card>

                                    {/* Employment Information */}
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                <Briefcase className="h-5 w-5" />
                                                {t('profile.employmentInformation')}
                                            </CardTitle>
                                        </CardHeader>
                                        <CardContent className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.staffNumber')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.staff_number}</p>
                                            </div>
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.position')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.position}</p>
                                            </div>
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.department')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.department}</p>
                                            </div>
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.section')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.section}</p>
                                            </div>
                                            {memberProfile.date_of_joining && (
                                                <div>
                                                    <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                        {t('membership.form.dateOfJoining')}
                                                    </label>
                                                    <p className={`mt-1 flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                        <Calendar className="h-4 w-4 text-gray-400" />
                                                        {formatDate(memberProfile.date_of_joining)}
                                                    </p>
                                                </div>
                                            )}
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.educationQualification')}
                                                </label>
                                                <p className={`mt-1 flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                    <GraduationCap className="h-4 w-4 text-gray-400" />
                                                    {memberProfile.education_qualification}
                                                </p>
                                            </div>
                                        </CardContent>
                                    </Card>

                                    {/* Contact Information */}
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                <Phone className="h-5 w-5" />
                                                {t('profile.contactInformation')}
                                            </CardTitle>
                                        </CardHeader>
                                        <CardContent className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.mobileNumber')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.mobile_number}</p>
                                            </div>
                                            {memberProfile.home_phone && (
                                                <div>
                                                    <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                        {t('membership.form.homePhone')}
                                                    </label>
                                                    <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.home_phone}</p>
                                                </div>
                                            )}
                                            {memberProfile.office_phone && (
                                                <div>
                                                    <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                        {t('membership.form.officePhone')}
                                                    </label>
                                                    <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.office_phone}</p>
                                                </div>
                                            )}
                                        </CardContent>
                                    </Card>

                                    {/* Address Information */}
                                    <Card>
                                        <CardHeader>
                                            <CardTitle className={`flex items-center gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                <MapPin className="h-5 w-5" />
                                                {t('profile.addressInformation')}
                                            </CardTitle>
                                        </CardHeader>
                                        <CardContent className="space-y-4">
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.permanentAddress')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.permanent_address}</p>
                                            </div>
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.workingPlaceAddress')}
                                                </label>
                                                <p className={`mt-1 flex items-start gap-2 ${isRTL ? 'font-arabic' : ''}`}>
                                                    <Building className="h-4 w-4 text-gray-400 mt-0.5 flex-shrink-0" />
                                                    {memberProfile.working_place_address}
                                                </p>
                                            </div>
                                        </CardContent>
                                    </Card>
                                </div>
                            ) : (
                                <Card>
                                    <CardHeader>
                                        <CardTitle className={`${isRTL ? 'font-arabic' : ''}`}>
                                            {t('profile.noMemberProfile')}
                                        </CardTitle>
                                        <CardDescription className={`${isRTL ? 'font-arabic' : ''}`}>
                                            {t('profile.noMemberProfileDescription')}
                                        </CardDescription>
                                    </CardHeader>
                                    <CardContent>
                                        <Button asChild>
                                            <Link href="/membership">
                                                <Users className="h-4 w-4 mr-2" />
                                                {t('profile.completeMembership')}
                                            </Link>
                                        </Button>
                                    </CardContent>
                                </Card>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}