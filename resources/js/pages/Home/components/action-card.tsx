import { t } from "i18next";

export default function HomeActionCard({
    title,
    description,
    link,
    linkText = t('home.learnMore'),
}: {
    title: string;
    description: string;
    link: string;
    linkText?: string;
}) {
    return (
        <div className="border rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
            <h2 className="text-xl font-semibold text-foreground mb-4">{title}</h2>
            <p className="text-foreground/70 mb-6">{description}</p>
            <a
                href={link}
                className="text-primary hover:text-primary/80 underline"
            >
                {linkText}
            </a>
        </div>
    );
}