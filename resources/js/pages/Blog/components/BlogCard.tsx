import ContentCard from './ContentCard';
import { Blog } from '@/types';

interface BlogCardProps {
    blog: Blog;
    index: number;
    renderContent: (content: any) => string;
    formatDate: (dateString: string) => string;
}

export default function BlogCard({ blog, index, renderContent, formatDate }: BlogCardProps) {
    return (
        <ContentCard
            item={blog}
            index={index}
            renderContent={renderContent}
            formatDate={formatDate}
            type="blog"
            href={`/news/${blog.id}`}
        />
    );
}