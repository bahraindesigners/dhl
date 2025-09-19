import ContentCard from '../../Blog/components/ContentCard';
import { Event } from '@/types';

interface EventCardProps {
    event: Event;
    index: number;
    renderContent: (content: any) => string;
    formatDate: (dateString: string) => string;
    formatTime: (dateString: string) => string;
}

export default function EventCard({ event, index, renderContent, formatDate, formatTime }: EventCardProps) {
    return (
        <ContentCard
            item={event}
            index={index}
            renderContent={renderContent}
            formatDate={formatDate}
            formatTime={formatTime}
            type="event"
            href={`/events/${event.id}`}
        />
    );
}