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
    gallery?: Array<{
        id: number;
        url: string;
        thumb: string;
        alt: string;
        width: number;
        height: number;
    }>;
    blog_category?: BlogCategory;
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
    price?: string;
    organizer?: string | Record<string, string>;
    organizer_details?: string | Record<string, string>;
    published_at?: string;
    author?: string | Record<string, string>;
    featured_image?: string;
    can_register?: boolean;
    spots_remaining?: number;
    is_upcoming?: boolean;
    is_ongoing?: boolean;
    is_past?: boolean;
    duration_in_hours?: number;
    duration_in_days?: number;
    gallery?: Array<{
        id: number;
        url: string;
        thumb?: string;
        alt?: string;
        width?: number;
        height?: number;
    }>;
    event_category?: EventCategory;
}

export interface BlogCategory {
    id: number;
    name: string | Record<string, string>;
    slug: string | Record<string, string>;
    description?: string | Record<string, string>;
    color?: string;
    icon?: string;
    sort_order: number;
    status: string;
}

export interface EventCategory {
    id: number;
    name: string | Record<string, string>;
    description?: string | Record<string, string>;
    color?: string;
    receiver_email?: string;
    is_active: boolean;
    sort_order: number;
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

export interface MemberProfile {
    mobile_number?: string;
    home_phone?: string;
}

export interface UserData {
    id: number;
    name: string;
    email: string;
    has_member_profile: boolean;
    is_registered?: boolean;
    member_profile?: MemberProfile;
}

export interface Download {
    id: number;
    title: string | Record<string, string>;
    description?: string | Record<string, string>;
    category: string;
    download_category_id?: number;
    access_level: 'public' | 'members';
    is_active: boolean;
    sort_order: number;
    download_count: number;
    file_size?: number;
    file_type?: string;
    file_url?: string;
    file_name?: string;
    file_extension?: string;
    file_size_formatted?: string;
    category_label: string;
    access_level_label: string;
    has_file: boolean;
    created_at: string;
    updated_at: string;
}

export interface DownloadCategory {
    id: number;
    name: string | Record<string, string>;
    description?: string | Record<string, string>;
    slug: string;
    is_active: boolean;
    sort_order: number;
    downloads: Download[];
    created_at: string;
    updated_at: string;
}
