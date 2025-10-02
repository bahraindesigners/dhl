import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { BookOpen, Folder, LayoutGrid, Banknote } from 'lucide-react';
import AppLogo from './app-logo';
import { useTranslation } from 'react-i18next';

export function AppSidebar() {
    const { i18n, t } = useTranslation();
    const { auth } = usePage().props as any;
    const n = i18n.dir() === 'ltr' ? 'left' : 'right';
    
    // Build navigation items based on user permissions
    const mainNavItems: NavItem[] = [
        {
            title: t('profile.title'),
            href: '/profile',
            icon: LayoutGrid,
        },
    ];

    // Add Union Loans if user has member profile
    if (auth.user && auth.user.memberProfile) {
        mainNavItems.push({
            title: t('loans.title'),
            href: '/loans',
            icon: Banknote,
        });
        
        mainNavItems.push({
            title: t('alHasala.title'),
            href: '/al-hasala',
            icon: Banknote,
        });
    }
    
    return (
        <Sidebar collapsible="icon" variant="inset" side={n}>
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/profile" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                {/* <NavFooter items={footerNavItems} className="mt-auto" /> */}
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
