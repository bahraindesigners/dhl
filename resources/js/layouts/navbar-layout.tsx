import { Navbar } from '@/components/navbar';
import { Footer } from '@/components/footer';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface NavbarLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default function NavbarLayout({ children, breadcrumbs }: NavbarLayoutProps) {
    return (
        <div className="min-h-screen bg-background flex flex-col">
            <Navbar />
            <main className="flex-1">
                {children}
            </main>
            <Footer />
        </div>
    );
}