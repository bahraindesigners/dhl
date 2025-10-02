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
    NavigationMenuContent,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { cn } from '@/lib/utils';
import { login, register } from '@/routes';
import { type SharedData } from '@/types';
import { Link, usePage, router } from '@inertiajs/react';
import {
    Home,
    Info,
    Newspaper,
    Calendar,
    Gift,
    BookOpen,
    Phone,
    LogOut,
    Menu,
    User,
    LogIn,
    Globe,
    ChevronDown,
    Users
} from "lucide-react";
import { useState, useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import { useLanguageDirection } from '@/hooks/use-language-direction';

interface NavItem {
    title: string;
    href?: string;
    description?: string;
    icon?: React.ComponentType<{ className?: string }>;
    children?: Omit<NavItem, 'children'>[];
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
            children: [
                {
                    title: t('nav.about'),
                    href: '/about',
                    description: t('nav.aboutDescription'),
                    icon: Info,
                },
                {
                    title: t('nav.qanda'),
                    href: '/questions-and-answers',
                    description: t('nav.qandaDescription'),
                    icon: Globe,
                },
            ]
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
            title: t('nav.membership'),
            icon: Users,
            description: 'Membership services and benefits',
            children: [
                {
                    title: t('nav.membership'),
                    href: '/membership',
                    description: t('nav.membershipDescription'),
                    icon: Users,
                },
                {
                    title: t('nav.offers'),
                    href: '/offers',
                    description: t('nav.offersDescription'),
                    icon: Gift,
                },
                {
                    title: t('nav.resources'),
                    href: '/resources',
                    description: t('nav.resourcesDescription'),
                    icon: BookOpen,
                },
                {
                    title: t('loans.title'),
                    href: '/loans',
                    description: t('loans.description'),
                    icon: BookOpen,
                },
                {
                    title: t('alHasala.title'),
                    href: '/al-hasala',
                    description: t('alHasala.description'),
                    icon: BookOpen,
                },
                {
                    title: t('complaints.myComplaints'),
                    href: '/complaints',
                    description: t('complaints.indexDescription'),
                    icon: Users,
                },
            ]
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
                    <NavigationMenuList className={cn(
                        "gap-1",
                        i18n.language === 'ar' ? 'flex-row-reverse' : 'flex-row'
                    )}>
                        {navigationItems.map((item) => {
                            const Icon = item.icon;

                            // If item has children, render as dropdown
                            if (item.children) {
                                return (
                                    <NavigationMenuItem key={item.title}>
                                        <NavigationMenuTrigger className={cn(
                                            'bg-transparent relative h-9 px-4 py-2 text-sm font-medium transition-all duration-200 hover:text-primary',
                                            'before:absolute before:bottom-0 before:left-1/2 before:h-0.5 before:w-0 before:-translate-x-1/2 before:bg-primary before:transition-all before:duration-300',
                                            (item.children.some(child => child.href && isActiveRoute(child.href))) &&
                                            'text-primary before:w-3/4'
                                        )}>
                                            <div className={cn(
                                                "flex items-center gap-2",
                                                i18n.language === 'ar' ? 'flex-row-reverse' : 'flex-row'
                                            )}>
                                                {Icon && <Icon className="h-4 w-4" />}
                                                <span>{item.title}</span>
                                            </div>
                                        </NavigationMenuTrigger>
                                        <NavigationMenuContent>
                                            <ul className="grid w-[400px] gap-3 p-4 md:w-[500px] md:grid-cols-2 lg:w-[600px]">
                                                {item.children.map((child) => {
                                                    const ChildIcon = child.icon;
                                                    return (
                                                        <li key={child.href}>
                                                            <NavigationMenuLink asChild>
                                                                <Link
                                                                    href={child.href!}
                                                                    className={cn(
                                                                        "block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground",
                                                                        child.href && isActiveRoute(child.href) && 'bg-accent text-primary'
                                                                    )}
                                                                >
                                                                    <div className={cn(
                                                                        "flex items-center gap-2 text-sm font-medium leading-none",


                                                                    )}
                                                                        dir={i18n.language === 'ar' ? 'rtl' : 'ltr'}
                                                                    >
                                                                        {ChildIcon && <ChildIcon className="h-4 w-4" />}
                                                                        {child.title}
                                                                    </div>
                                                                    <p className={
                                                                        "line-clamp-2 text-sm leading-snug text-muted-foreground" + (i18n.language === 'ar' ? ' text-right' : ' text-left')

                                                                    }>
                                                                        {child.description}
                                                                    </p>
                                                                </Link>
                                                            </NavigationMenuLink>
                                                        </li>
                                                    );
                                                })}
                                            </ul>
                                        </NavigationMenuContent>
                                    </NavigationMenuItem>
                                );
                            }

                            // Regular navigation item
                            return (
                                <NavigationMenuItem key={item.href}>
                                    <NavigationMenuLink
                                        asChild
                                        className={cn(
                                            navigationMenuTriggerStyle(),
                                            'bg-transparent relative h-9 px-4 py-2 text-sm font-medium transition-all duration-200 hover:text-primary',
                                            'before:absolute before:bottom-0 before:left-1/2 before:h-0.5 before:w-0 before:-translate-x-1/2 before:bg-primary before:transition-all before:duration-300',
                                            item.href && isActiveRoute(item.href) &&
                                            'text-primary before:w-3/4'
                                        )}
                                    >
                                        <Link href={item.href!} className={cn(
                                            "flex items-center gap-2",
                                            i18n.language === 'ar' ? 'flex-row-reverse' : 'flex-row'
                                        )}>
                                            {Icon && <Icon className="h-4 w-4" />}
                                            <span>{item.title}</span>
                                        </Link>
                                    </NavigationMenuLink>
                                </NavigationMenuItem>
                            );
                        })}
                    </NavigationMenuList>
                </NavigationMenu>

                {/* Right Side - Account & Language */}
                <div className={cn(
                    "flex items-center",
                    i18n.language === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3'
                )}>
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
                                        <span className="sr-only">{t('nav.account')}</span>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end" className="w-48">
                                    <div className="px-3 py-2 border-b">
                                        <p className="text-sm font-medium">{auth.user.name}</p>
                                        <p className="text-xs text-muted-foreground">{auth.user.email}</p>
                                    </div>
                                    <DropdownMenuItem asChild>
                                        <Link href="/profile">
                                            <User className={cn(
                                                "h-4 w-4",
                                                i18n.language === 'ar' ? 'ml-2' : 'mr-2'
                                            )} />
                                            {t('profile.title')}
                                        </Link>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem asChild>
                                        <Link href="/logout" method="post">
                                            <LogOut className={cn(
                                                "h-4 w-4",
                                                i18n.language === 'ar' ? 'ml-2' : 'mr-2'
                                            )} />
                                            {t('auth.signOut')}
                                        </Link>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        ) : (
                            <div className={cn(
                                "flex items-center",
                                i18n.language === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2'
                            )}>
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
                                <span className="sr-only">{t('nav.menu')}</span>
                            </Button>
                        </SheetTrigger>
                        <SheetContent side={i18n.language === "ar" ? "right" : "left"} className="w-80 p-0">
                            {/* Header Section */}
                            <div className="border-b bg-gradient-to-r from-primary/5 to-primary/10 p-6">
                                <h2 className="text-xl font-bold text-gray-900">{t('company.name')}</h2>
                                <p className="text-sm text-gray-600 mt-1">{t('company.tagline')}</p>
                            </div>

                            {/* Scrollable Navigation Content */}
                            <div className="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                <nav className="flex flex-col space-y-1 p-4">
                                    {navigationItems.map((item) => {
                                        const Icon = item.icon;

                                        // If item has children, render children directly in mobile
                                        if (item.children) {
                                            return (
                                                <div key={item.title} className="space-y-1 mb-4">
                                                    {/* Category Header */}
                                                    <div className="px-3 py-3 bg-gray-50 rounded-xl border border-gray-100">
                                                        <div className={cn(
                                                            "flex items-center",
                                                            i18n.language === 'ar' ? 'gap-x-reverse gap-x-3' : 'gap-x-3'
                                                        )}>
                                                            {Icon && <Icon className="h-5 w-5 text-gray-300" />}
                                                            <span className="text-sm font-semibold text-gray-400">{item.title}</span>
                                                        </div>
                                                    </div>

                                                    {/* Child Items */}
                                                    <div className={cn(
                                                        "space-y-1",
                                                        i18n.language === 'ar' ? 'mr-3' : 'ml-3'
                                                    )}>
                                                        {item.children.map((child) => {
                                                            const ChildIcon = child.icon;
                                                            const isActive = child.href && isActiveRoute(child.href);
                                                            return (
                                                                <Link
                                                                    key={child.href}
                                                                    href={child.href!}
                                                                    onClick={() => setIsOpen(false)}
                                                                    className={cn(
                                                                        'flex items-center rounded-xl p-3 text-sm font-medium transition-all duration-200 group',
                                                                        i18n.language === 'ar' ? 'gap-x-reverse gap-x-3' : 'gap-x-3',
                                                                        isActive
                                                                            ? 'bg-primary text-white shadow-md shadow-primary/25'
                                                                            : 'hover:bg-primary/5 hover:text-primary border border-transparent hover:border-primary/10'
                                                                    )}
                                                                >
                                                                    {ChildIcon && (
                                                                        <ChildIcon className={cn(
                                                                            "h-4 w-4 transition-colors",
                                                                            isActive ? "text-white" : "text-gray-500 group-hover:text-primary"
                                                                        )} />
                                                                    )}
                                                                    <span className="flex-1">{child.title}</span>
                                                                    {isActive && (
                                                                        <div className="h-2 w-2 rounded-full bg-white/30"></div>
                                                                    )}
                                                                </Link>
                                                            );
                                                        })}
                                                    </div>
                                                </div>
                                            );
                                        }

                                        // Regular navigation item
                                        const isActive = item.href && isActiveRoute(item.href);
                                        return (
                                            <Link
                                                key={item.href}
                                                href={item.href!}
                                                onClick={() => setIsOpen(false)}
                                                className={cn(
                                                    'flex items-center rounded-xl p-3 text-sm font-medium transition-all duration-200 group mb-1',
                                                    i18n.language === 'ar' ? 'gap-x-reverse gap-x-3' : 'gap-x-3',
                                                    isActive
                                                        ? 'bg-primary text-white shadow-md shadow-primary/25'
                                                        : 'hover:bg-primary/5 hover:text-primary border border-transparent hover:border-primary/10'
                                                )}
                                            >
                                                {Icon && (
                                                    <Icon className={cn(
                                                        "h-5 w-5 transition-colors",
                                                        isActive ? "text-white" : "text-gray-500 group-hover:text-primary"
                                                    )} />
                                                )}
                                                <span className="flex-1">{item.title}</span>
                                                {isActive && (
                                                    <div className="h-2 w-2 rounded-full bg-white/30"></div>
                                                )}
                                            </Link>
                                        );
                                    })}
                                </nav>

                                {/* Mobile User Section */}
                                <div className="border-t bg-gray-50/50 p-4 mt-4">
                                    {auth.user ? (
                                        <div className="gap-y-3">
                                            {/* User Profile Card */}
                                            <div className="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                                                <div className={cn(
                                                    "flex items-center mb-3",
                                                    i18n.language === 'ar' ? 'gap-x-reverse gap-x-3' : 'gap-x-3'
                                                )}>
                                                    <div className="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                                                        <User className="h-5 w-5 text-primary" />
                                                    </div>
                                                    <div className="flex-1 min-w-0">
                                                        <p className="text-sm font-semibold text-gray-900 truncate">{auth.user.name}</p>
                                                        <p className="text-xs text-gray-500 truncate">{auth.user.email}</p>
                                                    </div>
                                                </div>

                                                {/* User Actions */}
                                                <div className="gap-y-2">
                                                    <Link
                                                        href="/profile"
                                                        onClick={() => setIsOpen(false)}
                                                        className={cn(
                                                            "flex items-center rounded-lg p-2 text-sm font-medium hover:bg-gray-50 transition-colors",
                                                            i18n.language === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3'
                                                        )}
                                                    >
                                                        <User className="h-4 w-4 text-gray-500" />
                                                        <span>{t('profile.title')}</span>
                                                    </Link>
                                                    <Link
                                                        href="/logout"
                                                        method="post"
                                                        onClick={() => setIsOpen(false)}
                                                        className={cn(
                                                            "flex items-center rounded-lg p-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors",
                                                            i18n.language === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3'
                                                        )}
                                                    >
                                                        <LogOut className="h-4 w-4" />
                                                        <span>{t('auth.signOut')}</span>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    ) : (
                                        <div className="space-y-3">
                                            <Button asChild variant="outline" className="w-full justify-start h-12 rounded-xl border-2">
                                                <Link href={login()} onClick={() => setIsOpen(false)}>
                                                    <LogIn className={cn(
                                                        "h-5 w-5",
                                                        i18n.language === 'ar' ? 'ml-3' : 'mr-3'
                                                    )} />
                                                    {t('auth.signIn')}
                                                </Link>
                                            </Button>
                                            <Button asChild className="w-full h-12 rounded-xl shadow-md shadow-primary/25">
                                                <Link href={register()} onClick={() => setIsOpen(false)}>
                                                    <Users className={cn(
                                                        "h-5 w-5",
                                                        i18n.language === 'ar' ? 'ml-3' : 'mr-3'
                                                    )} />
                                                    {t('auth.joinUnion')}
                                                </Link>
                                            </Button>
                                        </div>
                                    )}


                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>
            </div>
        </header>
    );
}