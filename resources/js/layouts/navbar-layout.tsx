import { Navbar } from '@/components/navbar';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface NavbarLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default function NavbarLayout({ children, breadcrumbs }: NavbarLayoutProps) {
    return (
        <div className="min-h-screen bg-background">
            <Navbar />
            <main className="flex-1">
                {children}
            </main>
        </div>
    );
}