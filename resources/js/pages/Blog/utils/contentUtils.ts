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