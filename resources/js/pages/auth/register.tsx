import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import { login } from '@/routes';
import { Form, Head } from '@inertiajs/react';
import { LoaderCircle, User, Mail, Lock, UserPlus } from 'lucide-react';
import { useTranslation } from 'react-i18next';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';

export default function Register() {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    return (
        <AuthLayout title={t('auth.joinDhlUnion')} description={t('auth.createAccountDescription')}>
            <Head title={t('auth.createAccount')} />
            <Form
                {...RegisteredUserController.store.form()}
                resetOnSuccess={['password', 'password_confirmation']}
                disableWhileProcessing
                className="space-y-6"
            >
                {({ processing, errors }) => (
                    <>
                        <div className="space-y-4">
                            {/* Name Field */}
                            <div className="space-y-2">
                                <Label htmlFor="name" className={`text-sm font-medium text-gray-700 ${isRTL ? 'text-right' : 'text-left'}`}>
                                    {t('auth.fullName')}
                                </Label>
                                <div className="relative">
                                    <User className={`absolute ${isRTL ? 'right-3' : 'left-3'} top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400`} />
                                    <Input
                                        id="name"
                                        type="text"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="name"
                                        name="name"
                                        placeholder={t('auth.enterFullName')}
                                        className={`${isRTL ? 'pr-10 text-right' : 'pl-10'} h-12 border-gray-300 focus:border-primary focus:ring-primary`}
                                    />
                                </div>
                                <InputError message={errors.name} />
                            </div>

                            {/* Email Field */}
                            <div className="space-y-2">
                                <Label htmlFor="email" className={`text-sm font-medium text-gray-700 ${isRTL ? 'text-right' : 'text-left'}`}>
                                    {t('auth.emailAddress')}
                                </Label>
                                <div className="relative">
                                    <Mail className={`absolute ${isRTL ? 'right-3' : 'left-3'} top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400`} />
                                    <Input
                                        id="email"
                                        type="email"
                                        required
                                        tabIndex={2}
                                        autoComplete="email"
                                        name="email"
                                        placeholder={t('auth.enterEmail')}
                                        className={`${isRTL ? 'pr-10 text-right' : 'pl-10'} h-12 border-gray-300 focus:border-primary focus:ring-primary`}
                                    />
                                </div>
                                <InputError message={errors.email} />
                            </div>

                            {/* Password Field */}
                            <div className="space-y-2">
                                <Label htmlFor="password" className={`text-sm font-medium text-gray-700 ${isRTL ? 'text-right' : 'text-left'}`}>
                                    {t('auth.password')}
                                </Label>
                                <div className="relative">
                                    <Lock className={`absolute ${isRTL ? 'right-3' : 'left-3'} top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400`} />
                                    <Input
                                        id="password"
                                        type="password"
                                        required
                                        tabIndex={3}
                                        autoComplete="new-password"
                                        name="password"
                                        placeholder={t('auth.createPassword')}
                                        className={`${isRTL ? 'pr-10 text-right' : 'pl-10'} h-12 border-gray-300 focus:border-primary focus:ring-primary`}
                                    />
                                </div>
                                <InputError message={errors.password} />
                            </div>

                            {/* Confirm Password Field */}
                            <div className="space-y-2">
                                <Label htmlFor="password_confirmation" className={`text-sm font-medium text-gray-700 ${isRTL ? 'text-right' : 'text-left'}`}>
                                    {t('auth.confirmPassword')}
                                </Label>
                                <div className="relative">
                                    <Lock className={`absolute ${isRTL ? 'right-3' : 'left-3'} top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400`} />
                                    <Input
                                        id="password_confirmation"
                                        type="password"
                                        required
                                        tabIndex={4}
                                        autoComplete="new-password"
                                        name="password_confirmation"
                                        placeholder={t('auth.confirmPasswordPlaceholder')}
                                        className={`${isRTL ? 'pr-10 text-right' : 'pl-10'} h-12 border-gray-300 focus:border-primary focus:ring-primary`}
                                    />
                                </div>
                                <InputError message={errors.password_confirmation} />
                            </div>
                        </div>

                        {/* Register Button */}
                        <Button 
                            type="submit" 
                            className="w-full h-12 bg-primary hover:bg-primary/90 text-primary-foreground font-medium rounded-lg transition-colors duration-200" 
                            tabIndex={5}
                            disabled={processing}
                        >
                            {processing ? (
                                <>
                                    <LoaderCircle className="h-4 w-4 animate-spin mr-2" />
                                    {t('auth.creatingAccount')}
                                </>
                            ) : (
                                <>
                                    <UserPlus className="h-4 w-4 mr-2" />
                                    {t('auth.createAccount')}
                                </>
                            )}
                        </Button>

                        {/* Login Link */}
                        <div className="text-center pt-4 border-t border-gray-200">
                            <p className="text-sm text-gray-600">
                                {t('auth.alreadyHaveAccount')}{' '}
                                <TextLink 
                                    href={login()} 
                                    className="text-primary hover:text-primary/80 font-medium"
                                    tabIndex={6}
                                >
                                    {t('auth.signIn')}
                                </TextLink>
                            </p>
                        </div>
                    </>
                )}
            </Form>
        </AuthLayout>
    );
}
