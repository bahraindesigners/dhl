import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { cn } from '@/lib/utils';
import { dashboard, login, register } from '@/routes';
import { type SharedData } from '@/types';
import { Link, usePage, router } from '@inertiajs/react';
import {
    Home,
    Info,
    Newspaper,
    Calendar,
    BookOpen,
    Phone,
    LogOut,
    Menu,
    Settings,
    User,
    LogIn,
    Globe,
    ChevronDown
} from "lucide-react";
import { useState, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import { useLanguageDirection } from '@/hooks/use-language-direction';

interface NavItem {
    title: string;
    href: string;
    description?: string;
    icon?: React.ComponentType<{ className?: string }>;
}

export function Navbar() {
    const page = usePage<SharedData>();
    const { auth } = page.props;
    const [isOpen, setIsOpen] = useState(false);
    const { t, i18n } = useTranslation();
    useLanguageDirection(); // This will handle RTL/LTR switching

    // Synchronize sessionStorage with i18n on component mount
    useEffect(() => {
        const savedLanguage = sessionStorage.getItem('language');
        if (savedLanguage && savedLanguage !== i18n.language) {
            i18n.changeLanguage(savedLanguage);
        }
    }, [i18n]);

    // Get current locale from page props for backend content
    const currentLocale = (page.props as any).locale || 'en';

    const navigationItems: NavItem[] = [
        {
            title: t('nav.home'),
            href: '/',
            description: 'Return to homepage',
            icon: Home,
        },
        {
            title: t('nav.about'),
            href: '/about',
            description: 'Learn about our organization',
            icon: Info,
        },
        {
            title: t('nav.news'),
            href: '/news',
            description: 'Latest news and updates',
            icon: Newspaper,
        },
        {
            title: t('nav.events'),
            href: '/events',
            description: 'Upcoming events and meetings',
            icon: Calendar,
        },
        {
            title: t('nav.resources'),
            href: '/resources',
            description: 'Helpful resources and documents',
            icon: BookOpen,
        },
        {
            title: t('nav.contact'),
            href: '/contact',
            description: 'Get in touch with us',
            icon: Phone,
        },
    ];

    const changeLanguage = (lng: string) => {
        // Update frontend i18n


        // Also update backend session for dynamic content
        router.post('/language/switch', { locale: lng }, {
            preserveScroll: true,
            onSuccess: () => {
                // Save to session storage for persistence across page reloads
                sessionStorage.setItem('language', lng);
                window.location.reload();
            },
            onError: (errors) => {
                console.error('Failed to update backend language:', errors);
                // Still keep frontend change even if backend fails
            }
        });
    };

    const isActiveRoute = (href: string) => {
        if (href === '/') {
            return page.url === '/';
        }
        return page.url.startsWith(href);
    };

    return (
        <header className="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur-md supports-[backdrop-filter]:bg-background/80">
            <div className="container flex h-16 max-w-screen-2xl items-center justify-between px-6">
                {/* Company Name - Left */}
                <div className="flex items-center">
                    <Link href="/" className="text-xl font-bold text-foreground hover:text-primary transition-colors">
                        {t('company.name')}
                    </Link>
                </div>

                {/* Navigation Menu - Center */}
                <NavigationMenu className="hidden lg:flex">
                    <NavigationMenuList className="gap-1">
                        {navigationItems.map((item) => {
                            const Icon = item.icon;
                            return (
                                <NavigationMenuItem key={item.href}>
                                    <NavigationMenuLink
                                        asChild
                                        className={cn(
                                            navigationMenuTriggerStyle(),
                                            'relative h-9 px-4 py-2 text-sm font-medium transition-all duration-200 hover:text-primary',
                                            'before:absolute before:bottom-0 before:left-1/2 before:h-0.5 before:w-0 before:-translate-x-1/2 before:bg-primary before:transition-all before:duration-300',
                                            isActiveRoute(item.href) &&
                                            'text-primary before:w-3/4'
                                        )}
                                    >
                                        <Link href={item.href} className="flex flex-row items-center gap-2">
                                            {Icon && <Icon className="h-2 w-2 text-black" />}
                                            <span>{item.title}</span>
                                        </Link>
                                    </NavigationMenuLink>
                                </NavigationMenuItem>
                            );
                        })}
                    </NavigationMenuList>
                </NavigationMenu>

                {/* Right Side - Account & Language */}
                <div className="flex items-center space-x-3">
                    {/* Language Switcher */}
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="ghost" size="sm" >
                                {
                                    i18n.language === 'ar' ? (
                                        <span className="text-sm">🇸🇦 <span className='hidden lg:inline-block'>{t('languages.arabic')}</span></span>
                                    ) : (
                                        <span className="text-sm">🇺🇸 <span className='hidden lg:inline-block'>{t('languages.english')}</span></span>
                                    )
                                }
                                <ChevronDown className=" h-3 w-3 text-black" />
                                <span className="sr-only">{t('common.language')}</span>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" className="w-40">
                            <DropdownMenuItem
                                className={"cursor-pointer" + (i18n.language === 'en' ? ' font-bold bg-primary/30' : '')}
                                onClick={() => changeLanguage('en')}
                            >
                                <span className="text-sm">🇺🇸 {t('languages.english')}</span>
                            </DropdownMenuItem>
                            <DropdownMenuItem
                                className={"cursor-pointer" + (i18n.language === 'ar' ? ' font-bold bg-primary/30' : '')}
                                onClick={() => changeLanguage('ar')}
                            >
                                <span className="text-sm">🇸🇦 {t('languages.arabic')}</span>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>

                    {/* Account Menu */}
                    <div className="hidden lg:block">
                        {auth.user ? (
                            <DropdownMenu>
                                <DropdownMenuTrigger asChild>
                                    <Button variant="ghost" size="sm" className="h-9 w-9 rounded-full p-0">
                                        <User className="h-4 w-4 text-black" />
                                        <span className="sr-only">Account</span>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end" className="w-48">
                                    <div className="px-3 py-2 border-b">
                                        <p className="text-sm font-medium">{auth.user.name}</p>
                                        <p className="text-xs text-muted-foreground">{auth.user.email}</p>
                                    </div>
                                    <DropdownMenuItem asChild>
                                        <Link href={dashboard()}>
                                            <Settings className="mr-2 h-4 w-4" />
                                            {t('auth.dashboard')}
                                        </Link>
                                    </DropdownMenuItem>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem asChild>
                                        <Link href="/logout" method="post">
                                            <LogOut className="mr-2 h-4 w-4" />
                                            {t('auth.signOut')}
                                        </Link>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        ) : (
                            <div className="flex items-center space-x-2">
                                <Button variant="ghost" size="sm" asChild>
                                    <Link href={login()}>{t('auth.signIn')}</Link>
                                </Button>
                                <Button size="sm" asChild>
                                    <Link href={register()}>{t('auth.joinUnion')}</Link>
                                </Button>
                            </div>
                        )}
                    </div>

                    {/* Mobile Menu Toggle */}
                    <Sheet open={isOpen} onOpenChange={setIsOpen} >
                        <SheetTrigger asChild>
                            <Button variant="ghost" size="sm" className="lg:hidden">
                                <Menu className="h-5 w-5 text-black" />
                                <span className="sr-only">Menu</span>
                            </Button>
                        </SheetTrigger>
                        <SheetContent side={i18n.language === "ar" ? "right" : "left"} className="w-80">
                            <div className="mb-6">
                                <h2 className="text-lg font-semibold">{t('company.name')}</h2>
                            </div>
                            <nav className="flex flex-col space-y-3 p-4">
                                {navigationItems.map((item) => {
                                    const Icon = item.icon;
                                    return (
                                        <Link
                                            key={item.href}
                                            href={item.href}
                                            onClick={() => setIsOpen(false)}
                                            className={cn(
                                                'flex items-center space-x-3 rounded-lg p-3 text-sm font-medium transition-colors hover:bg-accent',
                                                isActiveRoute(item.href) && 'bg-accent text-primary'
                                            )}
                                        >
                                            {Icon && <Icon className="h-5 w-5 text-black" />}
                                            <span>{item.title}</span>
                                        </Link>
                                    );
                                })}
                            </nav>

                            {/* Mobile User Section */}
                            <div className="mt-8 border-t pt-6">
                                {auth.user ? (
                                    <div className="space-y-3">
                                        <div className="px-3 py-2 rounded-lg bg-accent/50">
                                            <p className="text-sm font-medium">{auth.user.name}</p>
                                            <p className="text-xs text-muted-foreground">{auth.user.email}</p>
                                        </div>
                                        <Link
                                            href={dashboard()}
                                            onClick={() => setIsOpen(false)}
                                            className="flex items-center space-x-3 rounded-lg p-3 text-sm font-medium hover:bg-accent"
                                        >
                                            <Settings className="h-5 w-5 text-black" />
                                            <span>{t('auth.dashboard')}</span>
                                        </Link>
                                        <Link
                                            href="/logout"
                                            method="post"
                                            onClick={() => setIsOpen(false)}
                                            className="flex items-center space-x-3 rounded-lg p-3 text-sm font-medium text-red-600 hover:bg-red-50"
                                        >
                                            <LogOut className="h-5 w-5" />
                                            <span>{t('auth.signOut')}</span>
                                        </Link>
                                    </div>
                                ) : (
                                    <div className="space-y-3">
                                        <Button asChild variant="ghost" className="w-full justify-start">
                                            <Link href={login()} onClick={() => setIsOpen(false)}>
                                                <LogIn className="mr-3 h-5 w-5" />
                                                {t('auth.signIn')}
                                            </Link>
                                        </Button>
                                        <Button asChild className="w-full">
                                            <Link href={register()} onClick={() => setIsOpen(false)}>
                                                {t('auth.joinUnion')}
                                            </Link>
                                        </Button>
                                    </div>
                                )}

                                {/* Mobile Language Switcher */}
                                <div className="mt-6 border-t pt-6">
                                    <h3 className="text-sm font-medium mb-3">{t('common.language')}</h3>
                                    <div className="space-y-2">
                                        <button
                                            className="flex items-center space-x-3 w-full p-2 text-sm rounded-lg hover:bg-accent"
                                            onClick={() => changeLanguage('en')}
                                        >
                                            <span>🇺🇸 {t('languages.english')}</span>
                                        </button>
                                        <button
                                            className="flex items-center space-x-3 w-full p-2 text-sm rounded-lg hover:bg-accent"
                                            onClick={() => changeLanguage('ar')}
                                        >
                                            <span>🇸🇦 {t('languages.arabic')}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>
            </div>
        </header>
    );
}