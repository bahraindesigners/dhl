import React from 'react';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { QrCode, User } from 'lucide-react';

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
}

interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
}

interface MemberCardProps {
    user: User;
    memberProfile: MemberProfile;
    isRTL?: boolean;
}

export default function MemberCard({ user, memberProfile, isRTL = false }: MemberCardProps) {
    // Determine color scheme based on gender
    const isMale = memberProfile.gender === 'male';

    const handleQRCodeClick = () => {
        // Generate the offers page URL with member ID
        const offersUrl = `${window.location.origin}/offers?member=${memberProfile.staff_number}`;
        window.open(offersUrl, '_blank');
    };

    // Split name into first and last name
    const nameParts = user.name.split(' ');
    const firstName = nameParts[0] || '';
    const lastName = nameParts.slice(1).join(' ') || '';

    return (
        <div className="w-full max-w-lg mx-auto px-4 sm:px-0" dir='ltr'>
            {/* ID Card Container */}
            <div
                className="relative bg-white rounded-2xl  overflow-hidden border border-gray-200"
                style={{ aspectRatio: '1.8/1', minHeight: '150px' }}
            >
                {/* Main Content Area */}
                <div className="relative p-3 sm:p-6 h-full flex flex-col z-10">

                    {/* Top Section with Photo, Text Block, and Logo */}
                    <div className="flex justify-between items-start mb-auto">

                        {/* Left Side: Photo and Text Block */}
                        <div className="flex gap-2 sm:gap-4 flex-1">
                            {/* Profile Photo - Responsive size */}
                            <div className="w-20 h-24 sm:w-28 sm:h-32 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border-2 border-gray-400 shadow-md">
                                {memberProfile.employee_image_url ? (
                                    <img
                                        src={memberProfile.employee_image_url}
                                        alt="Member Photo"
                                        className="w-full h-full object-cover"
                                    />
                                ) : (
                                    <div className="w-full h-full flex items-center justify-center bg-gray-50">
                                        <User className="h-8 w-8 sm:h-12 sm:w-12 text-gray-400" />
                                    </div>
                                )}
                            </div>

                            {/* Text Block */}
                            <div className="flex-1 space-y-1 sm:space-y-1 pt-1">
                                {/* Line 1: Position/Title */}
                                <div className="text-xs sm:text-sm font-medium text-gray-700 leading-tight">
                                    {memberProfile.position}
                                </div>

                                {/* Line 2: Name (LASTNAME Firstname) */}
                                <div className="text-sm sm:text-sm font-bold text-black leading-tight tracking-wide">
                                    <div className="uppercase">{lastName + " " + firstName}</div>
                                </div>

                                {/* Line 3: ID Number */}
                                <div className="text-xs sm:text-sm font-semibold text-gray-800 leading-tight">
                                    ID: {memberProfile.staff_number}
                                </div>

                                {/* Line 4: CPR Number */}
                                <div className="text-xs sm:text-sm font-semibold text-gray-800 leading-tight">
                                    CPR: {memberProfile.cpr_number}
                                </div>
                            </div>
                        </div>

                        {/* Top Right: DHL Logo */}
                        <div className="flex flex-col items-end ms-2 sm:ml-4 space-y-1 sm:space-y-2">
                            {/* DHL Logo */}
                            <img
                                src="/uinuon-logo.jpeg"
                                alt="DHL Logo"
                                className="shadow w-12 h-12 sm:w-16 sm:h-16 object-contain rounded-full"
                            />
                        </div>
                    </div>
                </div>

                {/* Background Image Design - Replace SVG waves */}
                <div className="absolute bottom-0 left-0 right-0 h-full pointer-events-none">
                    {/* Background Image */}
                    <div
                        className="absolute bottom-0 left-0 right-0 h-32 sm:h-40"
                        style={{
                            backgroundImage: 'url(/cardbackground.png)',
                            backgroundSize: '100% auto',
                            backgroundPosition: 'top center',
                            backgroundRepeat: 'no-repeat',
                            filter: isMale ? 'hue-rotate(30deg) saturate(1.2)' : 'hue-rotate(-10deg) saturate(1.1)'
                        }}
                    />

                    {/* Optional color overlay for gender theming */}
                    <div
                        className="absolute bottom-0 left-0 right-0 h-32 sm:h-40 mix-blend-multiply"
                        style={{
                            background: isMale
                                ? 'linear-gradient(to top, rgba(74, 43, 32, 0.3), transparent)'
                                : 'linear-gradient(to top, rgba(139, 26, 79, 0.3), transparent)'
                        }}
                    />

                    {/* Subtle gradient overlay for depth */}
                    <div className="absolute bottom-0 left-0 right-0 h-32 sm:h-40 bg-gradient-to-t from-black/10 to-transparent pointer-events-none" />
                </div>

                {/* Department Badge */}
                <div className="absolute bottom-2 sm:bottom-3 left-2 sm:left-4 z-20">
                    <Badge
                        className="text-white border-0 text-xs px-1 sm:px-2 py-1 shadow-sm"
                        style={{ backgroundColor: isMale ? '#4A2B20' : '#8B1A4F' }}
                    >
                        {memberProfile.department}
                    </Badge>
                </div>

                {/* Year Badge */}
                <div className="absolute bottom-2 sm:bottom-3 right-2 sm:right-4 z-20">
                    <Badge
                        variant="secondary"
                        className="text-xs bg-white/95 text-gray-700 border border-gray-200 px-1 sm:px-2 py-1 shadow-sm"
                    >
                        {new Date().getFullYear()}
                    </Badge>
                </div>

                {/* Card shine effect */}
                <div className="absolute top-0 left-0 right-0 h-full bg-gradient-to-br from-white/10 via-transparent to-transparent pointer-events-none" />
            </div>

            {/* QR Code underneath the card */}
            <div className="flex flex-col items-center mt-3 sm:mt-4 space-y-2">
                <div className="text-xs text-gray-600 font-medium">
                    Scan for Member Offers
                </div>
                <div
                    className="bg-white p-2 sm:p-3 rounded-lg shadow-md border border-gray-200 cursor-pointer hover:shadow-lg transition-shadow"
                    onClick={handleQRCodeClick}
                >
                    {/* QR Code Image */}
                    <img
                        src="/offersqr.png"
                        alt="QR Code for Member Offers"
                        className="w-24 h-24 sm:w-20 sm:h-20 object-contain"
                    />
                </div>
                <div className="text-xs text-gray-500 text-center max-w-32">
                    Click to access member offers and benefits
                </div>
            </div>
        </div>
    );
}