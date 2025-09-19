import { useForm } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { Event, UserData } from '@/types';
import { useState } from 'react';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { CheckCircle } from 'lucide-react';

interface EventRegistrationModalProps {
    event: Event;
    user: UserData | null;
    isOpen: boolean;
    onClose: () => void;
}

interface RegistrationForm {
    first_name: string;
    last_name: string;
    email: string;
    phone: string;
    special_requirements: string;
}

export default function EventRegistrationModal({ event, user, isOpen, onClose }: EventRegistrationModalProps) {
    const { t, i18n } = useTranslation();
    const [isSuccess, setIsSuccess] = useState(false);

    // Pre-fill form data from user profile
    const getInitialFormData = (): RegistrationForm => {
        if (!user) {
            return {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                special_requirements: '',
            };
        }

        // Split the user name into first and last name
        const nameParts = user.name.split(' ');
        const firstName = nameParts[0] || '';
        const lastName = nameParts.slice(1).join(' ') || '';

        // Use mobile number from member profile, fallback to home phone
        const phone = user.member_profile?.mobile_number || user.member_profile?.home_phone || '';

        return {
            first_name: firstName,
            last_name: lastName,
            email: user.email,
            phone: phone,
            special_requirements: '',
        };
    };

    const { data, setData, post, processing, errors } = useForm<RegistrationForm>(getInitialFormData());

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        post(`/events/${event.id}/register`, {
            onSuccess: () => {
                setData(getInitialFormData());
                setIsSuccess(true);
                // Show success message for 3 seconds, then reload
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            },
            onError: (errors) => {
                console.error('Registration errors:', errors);
            }
        });
    };

    const handleClose = () => {
        setData(getInitialFormData());
        setIsSuccess(false);
        onClose();
    };

    const eventTitle = typeof event.title === 'string' ? event.title : event.title[i18n.language] || event.title.en;

    return (
        <Dialog open={isOpen} onOpenChange={handleClose}>
            <DialogContent className="sm:max-w-[425px]">
                {isSuccess ? (
                    // Success view
                    <>
                        <DialogHeader>
                            <DialogTitle className="flex items-center gap-2">
                                <CheckCircle className="h-5 w-5 text-green-500" />
                                {t('events.registerForEvent') || 'Registration Successful!'}
                            </DialogTitle>
                        </DialogHeader>
                        
                        <div className="py-6 text-center">
                            <div className="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                <CheckCircle className="h-6 w-6 text-green-500" />
                            </div>
                            <p className="text-sm text-muted-foreground">
                                {t('events.congratulationsMessage') || 'Congratulations! You have been successfully registered for this event. We look forward to seeing you there!'}
                            </p>
                        </div>
                        
                        <DialogFooter>
                            <Button onClick={handleClose} className="w-full">
                                {t('common.close') || 'Close'}
                            </Button>
                        </DialogFooter>
                    </>
                ) : (
                    // Registration form
                    <>
                        <DialogHeader>
                            <DialogTitle>{t('events.registerForEvent') || 'Register for Event'}</DialogTitle>
                            <DialogDescription>
                                {eventTitle}
                            </DialogDescription>
                        </DialogHeader>
                        
                        <form onSubmit={handleSubmit} className="space-y-4">
                    <div className="grid grid-cols-2 gap-4">
                        <div className="space-y-2">
                            <Label htmlFor="first_name">
                                {t('events.firstName') || 'First Name'} *
                            </Label>
                            <Input
                                id="first_name"
                                value={data.first_name}
                                onChange={(e) => setData('first_name', e.target.value)}
                                placeholder={t('events.firstNamePlaceholder') || 'Enter your first name'}
                                required
                                aria-invalid={!!errors.first_name}
                            />
                            {errors.first_name && (
                                <p className="text-sm text-destructive">{errors.first_name}</p>
                            )}
                        </div>

                        <div className="space-y-2">
                            <Label htmlFor="last_name">
                                {t('events.lastName') || 'Last Name'} *
                            </Label>
                            <Input
                                id="last_name"
                                value={data.last_name}
                                onChange={(e) => setData('last_name', e.target.value)}
                                placeholder={t('events.lastNamePlaceholder') || 'Enter your last name'}
                                required
                                aria-invalid={!!errors.last_name}
                            />
                            {errors.last_name && (
                                <p className="text-sm text-destructive">{errors.last_name}</p>
                            )}
                        </div>
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="email">
                            {t('events.email') || 'Email Address'} *
                        </Label>
                        <Input
                            id="email"
                            type="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            placeholder={t('events.emailPlaceholder') || 'Enter your email address'}
                            required
                            aria-invalid={!!errors.email}
                        />
                        {errors.email && (
                            <p className="text-sm text-destructive">{errors.email}</p>
                        )}
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="phone">
                            {t('events.phone') || 'Phone Number'} *
                        </Label>
                        <Input
                            id="phone"
                            type="tel"
                            value={data.phone}
                            onChange={(e) => setData('phone', e.target.value)}
                            placeholder={t('events.phonePlaceholder') || 'Enter your phone number'}
                            required
                            aria-invalid={!!errors.phone}
                        />
                        {errors.phone && (
                            <p className="text-sm text-destructive">{errors.phone}</p>
                        )}
                    </div>

                    <div className="space-y-2">
                        <Label htmlFor="special_requirements">
                            {t('events.specialRequirements') || 'Special Requirements'}
                        </Label>
                        <Textarea
                            id="special_requirements"
                            value={data.special_requirements}
                            onChange={(e) => setData('special_requirements', e.target.value)}
                            placeholder={t('events.specialRequirementsPlaceholder') || 'Any dietary restrictions, accessibility needs, or other requirements...'}
                            rows={3}
                        />
                        {errors.special_requirements && (
                            <p className="text-sm text-destructive">{errors.special_requirements}</p>
                        )}
                    </div>

                    <DialogFooter>
                        <Button type="button" variant="outline" onClick={handleClose}>
                            {t('common.cancel') || 'Cancel'}
                        </Button>
                        <Button type="submit" disabled={processing}>
                            {processing ? 
                                (t('events.registering') || 'Registering...') : 
                                (t('events.registerNow') || 'Register Now')
                            }
                        </Button>
                    </DialogFooter>
                </form>
                    </>
                )}
            </DialogContent>
        </Dialog>
    );
}