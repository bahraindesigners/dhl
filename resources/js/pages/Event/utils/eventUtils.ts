/**
 * Helper function to convert TipTap JSON to HTML
 */
export const tiptapToHtml = (tiptapJson: any): string => {
    if (typeof tiptapJson === 'string') {
        return tiptapJson;
    }

    if (!tiptapJson || !tiptapJson.content) {
        return '';
    }

    const processNode = (node: any): string => {
        if (node.type === 'paragraph') {
            const content = node.content ? node.content.map(processNode).join('') : '';
            return `<p>${content}</p>`;
        }
        
        if (node.type === 'text') {
            return node.text || '';
        }
        
        if (node.type === 'heading') {
            const level = node.attrs?.level || 1;
            const content = node.content ? node.content.map(processNode).join('') : '';
            return `<h${level}>${content}</h${level}>`;
        }

        if (node.type === 'bulletList') {
            const content = node.content ? node.content.map(processNode).join('') : '';
            return `<ul>${content}</ul>`;
        }

        if (node.type === 'orderedList') {
            const content = node.content ? node.content.map(processNode).join('') : '';
            return `<ol>${content}</ol>`;
        }

        if (node.type === 'listItem') {
            const content = node.content ? node.content.map(processNode).join('') : '';
            return `<li>${content}</li>`;
        }

        if (node.type === 'blockquote') {
            const content = node.content ? node.content.map(processNode).join('') : '';
            return `<blockquote>${content}</blockquote>`;
        }

        if (node.content) {
            return node.content.map(processNode).join('');
        }

        return '';
    };

    return tiptapJson.content.map(processNode).join('');
};

/**
 * Helper function to render content - handles both HTML strings and TipTap JSON
 */
export const renderContent = (content: any): string => {
    if (typeof content === 'string') {
        return content;
    }
    
    if (content && typeof content === 'object' && content.type === 'doc') {
        return tiptapToHtml(content);
    }
    
    return String(content || '');
};

/**
 * Helper function to format date based on locale
 */
export const formatDate = (dateString: string, locale: string = 'en-US'): string => {
    const date = new Date(dateString);
    return date.toLocaleDateString(locale === 'ar' ? 'ar-BH' : 'en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

/**
 * Helper function to format time based on locale
 */
export const formatTime = (dateString: string, locale: string = 'en-US'): string => {
    const date = new Date(dateString);
    return date.toLocaleTimeString(locale === 'ar' ? 'ar-BH' : 'en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
};

/**
 * Helper function to format event date range
 */
export const formatEventDate = (startDate: string, endDate: string, locale: string = 'en-US'): string => {
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    // If same day, just show one date
    if (start.toDateString() === end.toDateString()) {
        return formatDate(startDate, locale);
    }
    
    // Different days
    return `${formatDate(startDate, locale)} - ${formatDate(endDate, locale)}`;
};

/**
 * Helper function to format event time range
 */
export const formatEventTime = (startDate: string, endDate?: string, locale: string = 'en-US'): string => {
    const start = new Date(startDate);
    
    if (!endDate) {
        return formatTime(startDate, locale);
    }
    
    const end = new Date(endDate);
    
    // If same day, show time range
    if (start.toDateString() === end.toDateString()) {
        return `${formatTime(startDate, locale)} - ${formatTime(endDate, locale)}`;
    }
    
    // Different days, show date and time for both
    return `${formatDate(startDate, locale)} ${formatTime(startDate, locale)} - ${formatDate(endDate, locale)} ${formatTime(endDate, locale)}`;
};

/**
 * Helper function to get event status
 */
export const getEventStatus = (startDate: string, endDate: string): 'upcoming' | 'ongoing' | 'past' => {
    const now = new Date();
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    if (now < start) {
        return 'upcoming';
    } else if (now >= start && now <= end) {
        return 'ongoing';
    } else {
        return 'past';
    }
};

/**
 * Helper function to get days until event
 */
export const getDaysUntil = (startDate: string): number => {
    const now = new Date();
    const start = new Date(startDate);
    const diffTime = start.getTime() - now.getTime();
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays;
};