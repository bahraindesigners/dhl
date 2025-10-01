import { Head, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import NavbarLayout from '@/layouts/navbar-layout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type SharedData } from '@/types';
import MemberCard from '@/components/MemberCard';
import CollapsibleSection from '@/components/CollapsibleSection';
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
    CheckCircle,
    XCircle,
    Camera,
    FileText,
    Download,
    Eye
} from 'lucide-react';

interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
}

interface MediaFile {
    id: number;
    name: string;
    file_name: string;
    mime_type: string;
    size: number;
    human_readable_size: string;
    url: string;
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
    employee_image_url?: string;
    signature_url?: string;
    withdrawal_letters: MediaFile[];
    additional_files: MediaFile[];
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
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    {/* Page Header */}
                    <div className="mb-8">
                        <h1 className={`text-3xl font-bold text-gray-900 ${isRTL ? 'font-arabic' : ''}`}>
                            {t('auth.profile')}
                        </h1>
                    </div>

                    {/* Flash Messages */}
                    {(flash?.success || flash?.info || flash?.error) && (
                        <div className="mb-6 space-y-4">
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

                    {memberProfile ? (
                        <div className="space-y-6">
                            {/* Member Card */}
                            <div className="flex justify-center mb-8">
                                <MemberCard 
                                    user={user} 
                                    memberProfile={memberProfile} 
                                    isRTL={isRTL} 
                                />
                            </div>

                            {/* Collapsible Information Sections */}
                            <div className="space-y-4">
                                {/* Account Information */}
                                <CollapsibleSection
                                    title="Account Information"
                                    icon={<User className="h-5 w-5" />}
                                    defaultOpen={true}
                                    isRTL={isRTL}
                                >
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                Email Address
                                            </label>
                                            <div className="mt-1 flex items-center gap-2">
                                                <Mail className="h-4 w-4 text-gray-400" />
                                                <span className={`${isRTL ? 'font-arabic' : ''}`}>{user.email}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                Email Verified
                                            </label>
                                            <div className="mt-1">
                                                {user.email_verified_at ? (
                                                    <Badge variant="default" className="flex items-center gap-1 w-fit">
                                                        <CheckCircle className="h-3 w-3" />
                                                        Verified
                                                    </Badge>
                                                ) : (
                                                    <Badge variant="destructive" className="flex items-center gap-1 w-fit">
                                                        <XCircle className="h-3 w-3" />
                                                        Not Verified
                                                    </Badge>
                                                )}
                                            </div>
                                        </div>
                                        <div>
                                            <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                Member Since
                                            </label>
                                            <div className="mt-1 flex items-center gap-2">
                                                <Calendar className="h-4 w-4 text-gray-400" />
                                                <span className={`${isRTL ? 'font-arabic' : ''}`}>
                                                    {formatDate(user.created_at)}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                Profile Status
                                            </label>
                                            <div className="mt-1">
                                                {memberProfile.profile_status ? (
                                                    <Badge variant="default" className="flex items-center gap-1 w-fit">
                                                        <CheckCircle className="h-3 w-3" />
                                                        Active
                                                    </Badge>
                                                ) : (
                                                    <Badge variant="secondary" className="flex items-center gap-1 w-fit">
                                                        <XCircle className="h-3 w-3" />
                                                        Pending
                                                    </Badge>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <Separator className="my-4" />
                                    
                                    <div className="text-center">
                                        <p className={`text-xs text-gray-500 ${isRTL ? 'font-arabic' : ''}`}>
                                            Profile managed by administration
                                        </p>
                                    </div>
                                </CollapsibleSection>

                                {/* Personal Information */}
                                <CollapsibleSection
                                    title={t('profile.personalInformation')}
                                    icon={<Users className="h-5 w-5" />}
                                    isRTL={isRTL}
                                >
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                    </div>
                                </CollapsibleSection>

                                {/* Employment Information */}
                                <CollapsibleSection
                                    title={t('profile.employmentInformation')}
                                    icon={<Briefcase className="h-5 w-5" />}
                                    isRTL={isRTL}
                                >
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                        {memberProfile.section && (
                                            <div>
                                                <label className={`text-sm font-medium text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                                    {t('membership.form.section')}
                                                </label>
                                                <p className={`mt-1 ${isRTL ? 'font-arabic' : ''}`}>{memberProfile.section}</p>
                                            </div>
                                        )}
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
                                    </div>
                                </CollapsibleSection>

                                {/* Contact Information */}
                                <CollapsibleSection
                                    title={t('profile.contactInformation')}
                                    icon={<Phone className="h-5 w-5" />}
                                    isRTL={isRTL}
                                >
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                    </div>
                                </CollapsibleSection>

                                {/* Address Information */}
                                <CollapsibleSection
                                    title={t('profile.addressInformation')}
                                    icon={<MapPin className="h-5 w-5" />}
                                    isRTL={isRTL}
                                >
                                    <div className="space-y-4">
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
                                    </div>
                                </CollapsibleSection>

                                {/* Digital Signature */}
                                {memberProfile.signature_url && (
                                    <CollapsibleSection
                                        title="Digital Signature"
                                        icon={<Camera className="h-5 w-5" />}
                                        isRTL={isRTL}
                                    >
                                        <div className="text-center">
                                            <img 
                                                src={memberProfile.signature_url} 
                                                alt="Digital Signature"
                                                className="max-w-full h-auto max-h-32 mx-auto border rounded"
                                            />
                                            <Button 
                                                variant="outline" 
                                                size="sm" 
                                                className="mt-4"
                                                onClick={() => window.open(memberProfile.signature_url, '_blank')}
                                            >
                                                <Eye className="h-4 w-4 mr-2" />
                                                View Full Size
                                            </Button>
                                        </div>
                                    </CollapsibleSection>
                                )}

                                {/* Documents */}
                                {(memberProfile.withdrawal_letters.length > 0 || memberProfile.additional_files.length > 0) && (
                                    <CollapsibleSection
                                        title="Documents & Files"
                                        icon={<FileText className="h-5 w-5" />}
                                        isRTL={isRTL}
                                    >
                                        <div className="space-y-6">
                                            {memberProfile.withdrawal_letters.length > 0 && (
                                                <div>
                                                    <h4 className={`font-medium text-gray-900 mb-3 ${isRTL ? 'font-arabic' : ''}`}>
                                                        Withdrawal Letters
                                                    </h4>
                                                    <div className="space-y-2">
                                                        {memberProfile.withdrawal_letters.map((file) => (
                                                            <div key={file.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                                <div className="flex items-center gap-3">
                                                                    <FileText className="h-5 w-5 text-blue-600" />
                                                                    <div>
                                                                        <span className="text-sm font-medium">{file.name}</span>
                                                                        <p className="text-xs text-gray-500">({file.human_readable_size})</p>
                                                                    </div>
                                                                </div>
                                                                <Button 
                                                                    variant="outline" 
                                                                    size="sm"
                                                                    onClick={() => window.open(file.url, '_blank')}
                                                                >
                                                                    <Download className="h-4 w-4 mr-2" />
                                                                    Download
                                                                </Button>
                                                            </div>
                                                        ))}
                                                    </div>
                                                </div>
                                            )}

                                            {memberProfile.additional_files.length > 0 && (
                                                <div>
                                                    <h4 className={`font-medium text-gray-900 mb-3 ${isRTL ? 'font-arabic' : ''}`}>
                                                        Additional Documents
                                                    </h4>
                                                    <div className="space-y-2">
                                                        {memberProfile.additional_files.map((file) => (
                                                            <div key={file.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                                <div className="flex items-center gap-3">
                                                                    <FileText className="h-5 w-5 text-green-600" />
                                                                    <div>
                                                                        <span className="text-sm font-medium">{file.name}</span>
                                                                        <p className="text-xs text-gray-500">({file.human_readable_size})</p>
                                                                    </div>
                                                                </div>
                                                                <Button 
                                                                    variant="outline" 
                                                                    size="sm"
                                                                    onClick={() => window.open(file.url, '_blank')}
                                                                >
                                                                    <Download className="h-4 w-4 mr-2" />
                                                                    Download
                                                                </Button>
                                                            </div>
                                                        ))}
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </CollapsibleSection>
                                )}
                            </div>
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
                                            Member Profile Required
                                        </h2>
                                        <p className={`text-lg text-gray-600 ${isRTL ? 'font-arabic' : ''}`}>
                                            Please contact the administration to create your member profile.
                                        </p>
                                        <p className={`text-sm text-gray-500 mt-2 ${isRTL ? 'font-arabic' : ''}`}>
                                            Member profiles are now managed exclusively by the administration team.
                                        </p>
                                    </div>
                                </div>
                            )}
                        </div>
                    )}
                </div>
            </div>
        </NavbarLayout>
    );
}