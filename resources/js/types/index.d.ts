import { InertiaLinkProps } from '@inertiajs/react';
import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface HomeSlider {
    id: number;
    title: string | Record<string, string>;
    subtitle: string | Record<string, string>;
    description: string | Record<string, string>;
    button_text: string | Record<string, string>;
    button_url: string;
    desktop_image: string;
    mobile_image: string;
    sort_order: number;
}

export interface Blog {
    id: number;
    title: string | Record<string, string>;
    slug: string | Record<string, string>;
    excerpt: string | Record<string, string>;
    content: string | Record<string, string>;
    author: string;
    status: string;
    featured: boolean;
    show_as_urgent_news: boolean;
    published_at: string;
    views_count: number;
    reading_time: number;
    featured_image?: string;
    blog_category?: {
        id: number;
        name: string | Record<string, string>;
    };
}

export interface Event {
    id: number;
    title: string | Record<string, string>;
    slug: string | Record<string, string>;
    description: string | Record<string, string>;
    content: string | Record<string, string>;
    start_date: string;
    end_date: string;
    timezone: string;
    status: string;
    priority: string;
    featured: boolean;
    location?: string;
    location_details?: string | Record<string, string>;
    capacity?: number;
    registered_count: number;
    registration_enabled: boolean;
    registration_starts_at?: string;
    registration_ends_at?: string;
    price?: number;
    organizer?: string | Record<string, string>;
    organizer_details?: string | Record<string, string>;
    published_at?: string;
    author?: string | Record<string, string>;
    featured_image?: string;
    event_category?: {
        id: number;
        name: string | Record<string, string>;
    };
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface About {
    id: number;
    title: string | Record<string, string>;
    content: string | Record<string, string>;
    show_board_section: boolean;
    board_section_title?: string | Record<string, string>;
    board_section_description?: string | Record<string, string>;
}

export interface BoardMember {
    id: number;
    name: string | Record<string, string>;
    position: string | Record<string, string>;
    description?: string | Record<string, string>;
    sort_order: number;
    is_active?: boolean;
    avatar_url?: string;
    avatar_thumb_url?: string;
    avatar_medium_url?: string;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}
