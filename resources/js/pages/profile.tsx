import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type SharedData } from '@/types';
import PersonalInformation from '@/pages/Membership/components/PersonalInformation';
import EmploymentInformation from '@/pages/Membership/components/EmploymentInformation';
import ContactInformation from '@/pages/Membership/components/ContactInformation';
import SignatureSection from '@/pages/Membership/components/SignatureSection';
import Attachments from '@/pages/Membership/components/Attachments';
import MultiStepForm from '@/pages/Membership/components/MultiStepForm';
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

interface MembershipSettings {
    enable_member_form: boolean;
}

interface Props {
    user: User;
    memberProfile: MemberProfile | null;
    membershipSettings: MembershipSettings;
}

export default function Profile({ user, memberProfile, membershipSettings }: Props) {
    const { t, i18n } = useTranslation();
    const { auth, flash } = usePage<SharedData & { flash: { success?: string; error?: string; info?: string } }>().props;
    const isRTL = i18n.language === 'ar';
    const isFormEnabled = membershipSettings.enable_member_form;
    const hasAnyMemberProfile = Boolean(auth.memberProfile);

    const { data, setData, post, processing, errors } = useForm({
        phone: '',
        cpr_number: '',
        staff_number: '',
        nationality: '',
        gender: '',
        marital_status: '',
        date_of_joining: '',
        position: '',
        department: '',
        section: '',
        working_place_address: '',
        office_phone: '',
        education_qualification: '',
        mobile_number: '',
        home_phone: '',
        permanent_address: '',
        message: '',
        signature: '',
        was_previous_member: 'no',
        withdrawal_letter: null as File | null,
    });

    const submit = () => {
        post('/membership', {
            forceFormData: true,
            preserveScroll: true,
        });
    };

    const formSteps = [
        {
            id: 'personal',
            title: t('membership.form.personalInformation'),
            component: (
                <PersonalInformation
                    data={data}
                    setData={setData}
                    errors={errors}
                    isRTL={isRTL}
                    user={user}
                />
            ),
            validate: () => {
                return !!(
                    data.mobile_number &&
                    data.cpr_number &&
                    data.nationality &&
                    data.gender &&
                    data.marital_status
                );
            },
        },
        {
            id: 'employment',
            title: t('membership.form.employmentInformation'),
            component: (
                <EmploymentInformation
                    data={data}
                    setData={setData}
                    errors={errors}
                    isRTL={isRTL}
                />
            ),
            validate: () => {
                return !!(
                    data.staff_number &&
                    data.date_of_joining &&
                    data.position &&
                    data.department &&
                    data.section
                );
            },
        },
        {
            id: 'contact',
            title: t('membership.form.contactInformation'),
            component: (
                <ContactInformation
                    data={data}
                    setData={setData}
                    errors={errors}
                    isRTL={isRTL}
                />
            ),
            validate: () => {
                return !!data.permanent_address;
            },
        },
        {
            id: 'signature',
            title: t('membership.form.signature'),
            component: (
                <div className="space-y-8">
                    <SignatureSection
                        data={data}
                        setData={setData}
                        errors={errors}
                        isRTL={isRTL}
                    />
                    <Attachments
                        data={data}
                        setData={setData}
                        errors={errors}
                        isRTL={isRTL}
                    />
                </div>
            ),
            validate: () => {
                return !!data.signature;
            },
        },
    ];

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

                    {(flash?.success || flash?.error || flash?.info) && (
                        <div className="mb-8 space-y-3">
                            {flash?.success && (
                                <div className={`rounded-md bg-green-50 p-4 ${isRTL ? 'font-arabic' : ''}`}>
                                    <div className="flex">
                                        <div className="flex-shrink-0">
                                            <svg className="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                            </svg>
                                        </div>
                                        <div className="ml-3">
                                            <p className="text-sm font-medium text-green-800">{flash.success}</p>
                                        </div>
                                    </div>
                                </div>
                            )}
                            {flash?.info && (
                                <div className={`rounded-md bg-blue-50 p-4 ${isRTL ? 'font-arabic' : ''}`}>
                                    <div className="flex">
                                        <div className="flex-shrink-0">
                                            <svg className="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clipRule="evenodd" />
                                            </svg>
                                        </div>
                                        <div className="ml-3">
                                            <p className="text-sm font-medium text-blue-800">{flash.info}</p>
                                        </div>
                                    </div>
                                </div>
                            )}
                            {flash?.error && (
                                <div className={`rounded-md bg-red-50 p-4 ${isRTL ? 'font-arabic' : ''}`}>
                                    <div className="flex">
                                        <div className="flex-shrink-0">
                                            <svg className="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clipRule="evenodd" />
                                            </svg>
                                        </div>
                                        <div className="ml-3">
                                            <p className="text-sm font-medium text-red-800">{flash.error}</p>
                                        </div>
                                    </div>
                                </div>
                            )}
                        </div>
                    )}

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
                                <div className="space-y-6">
                                    {!isFormEnabled ? (
                                        <Card>
                                            <CardHeader>
                                                <CardTitle className={`${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('profile.noMemberProfile')}
                                                </CardTitle>
                                                <CardDescription className={`${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('profile.noMemberProfileDescription')}
                                                </CardDescription>
                                            </CardHeader>
                                        </Card>
                                    ) : hasAnyMemberProfile ? (
                                        <div className={`max-w-3xl mx-auto p-6 bg-green-50 border border-green-200 rounded-lg text-center ${isRTL ? 'font-arabic' : ''}`}>
                                            <h3 className="text-xl font-semibold text-green-800 mb-2">
                                                {t('membership.alreadyMemberTitle')}
                                            </h3>
                                            <p className="text-green-700">
                                                {t('membership.alreadyMemberMessage')}
                                            </p>
                                        </div>
                                    ) : (
                                        <div className="space-y-8">
                                            <div className="text-center">
                                                <h2 className={`text-2xl sm:text-3xl font-bold text-gray-900 mb-3 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.joinToday')}
                                                </h2>
                                                <p className={`text-lg text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.fillOutForm')}
                                                </p>
                                            </div>
                                            <form onSubmit={(e) => e.preventDefault()}>
                                                <MultiStepForm
                                                    steps={formSteps}
                                                    onSubmit={submit}
                                                    isSubmitting={processing}
                                                    isRTL={isRTL}
                                                    data={data}
                                                    errors={errors}
                                                />
                                            </form>
                                        </div>
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}