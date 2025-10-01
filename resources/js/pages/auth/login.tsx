import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/react';
import { LoaderCircle, Mail, Lock, User } from 'lucide-react';
import { useTranslation } from 'react-i18next';

interface LoginProps {
    status?: string;
    canResetPassword: boolean;
}

export default function Login({ status, canResetPassword }: LoginProps) {
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';

    return (
        <AuthLayout title={t('auth.welcomeBack')} description={t('auth.signInDescription')}>
            <Head title={t('auth.login')} />

            {status && (
                <div className="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p className="text-sm text-green-700 text-center">{status}</p>
                </div>
            )}

            <Form {...AuthenticatedSessionController.store.form()} resetOnSuccess={['password']} className="space-y-6">
                {({ processing, errors }) => (
                    <>
                        <div className="space-y-4">
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
                                        name="email"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="email"
                                        placeholder={t('auth.enterEmail')}
                                        className={`${isRTL ? 'pr-10 text-right' : 'pl-10'} h-12 border-gray-300 focus:border-primary focus:ring-primary`}
                                    />
                                </div>
                                <InputError message={errors.email} />
                            </div>

                            {/* Password Field */}
                            <div className="space-y-2">
                                <div className="flex items-center justify-between">
                                    <Label htmlFor="password" className={`text-sm font-medium text-gray-700 ${isRTL ? 'text-right' : 'text-left'}`}>
                                        {t('auth.password')}
                                    </Label>
                                    {canResetPassword && (
                                        <TextLink 
                                            href={request()} 
                                            className="text-sm text-primary hover:text-primary/80" 
                                            tabIndex={5}
                                        >
                                            {t('auth.forgotPassword')}
                                        </TextLink>
                                    )}
                                </div>
                                <div className="relative">
                                    <Lock className={`absolute ${isRTL ? 'right-3' : 'left-3'} top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400`} />
                                    <Input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        tabIndex={2}
                                        autoComplete="current-password"
                                        placeholder={t('auth.enterPassword')}
                                        className={`${isRTL ? 'pr-10 text-right' : 'pl-10'} h-12 border-gray-300 focus:border-primary focus:ring-primary`}
                                    />
                                </div>
                                <InputError message={errors.password} />
                            </div>

                            {/* Remember Me */}
                            <div className={`flex items-center space-x-3 ${isRTL ? 'space-x-reverse' : ''}`}>
                                <Checkbox 
                                    id="remember" 
                                    name="remember" 
                                    tabIndex={3}
                                    className="border-gray-300"
                                />
                                <Label htmlFor="remember" className="text-sm text-gray-700">
                                    {t('auth.rememberMe')}
                                </Label>
                            </div>
                        </div>

                        {/* Login Button */}
                        <Button 
                            type="submit" 
                            className="w-full h-12 bg-primary hover:bg-primary/90 text-primary-foreground font-medium rounded-lg transition-colors duration-200" 
                            tabIndex={4} 
                            disabled={processing}
                        >
                            {processing ? (
                                <>
                                    <LoaderCircle className="h-4 w-4 animate-spin mr-2" />
                                    {t('auth.signingIn')}
                                </>
                            ) : (
                                <>
                                    <User className="h-4 w-4 mr-2" />
                                    {t('auth.signIn')}
                                </>
                            )}
                        </Button>

                        {/* Sign Up Link */}
                        <div className="text-center pt-4 border-t border-gray-200">
                            <p className="text-sm text-gray-600">
                                {t('auth.dontHaveAccount')}{' '}
                                <TextLink 
                                    href={register()} 
                                    className="text-primary hover:text-primary/80 font-medium"
                                    tabIndex={6}
                                >
                                    {t('auth.createAccount')}
                                </TextLink>
                            </p>
                        </div>
                    </>
                )}
            </Form>
        </AuthLayout>
    );
}
