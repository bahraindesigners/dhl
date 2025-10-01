import React, { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { ChevronDown, ChevronUp } from 'lucide-react';

interface CollapsibleSectionProps {
    title: string;
    icon?: React.ReactNode;
    children: React.ReactNode;
    defaultOpen?: boolean;
    isRTL?: boolean;
    className?: string;
}

export default function CollapsibleSection({ 
    title, 
    icon, 
    children, 
    defaultOpen = false, 
    isRTL = false,
    className = ''
}: CollapsibleSectionProps) {
    const [isOpen, setIsOpen] = useState(defaultOpen);

    return (
        <Card className={`transition-all duration-200 ${className}`}>
            <CardHeader 
                className="cursor-pointer hover:bg-gray-50 transition-colors"
                onClick={() => setIsOpen(!isOpen)}
            >
                <CardTitle className={`flex items-center justify-between ${isRTL ? 'font-arabic' : ''}`}>
                    <div className="flex items-center gap-2">
                        {icon}
                        <span>{title}</span>
                    </div>
                    <div className="text-gray-400">
                        {isOpen ? (
                            <ChevronUp className="h-5 w-5" />
                        ) : (
                            <ChevronDown className="h-5 w-5" />
                        )}
                    </div>
                </CardTitle>
            </CardHeader>
            
            {isOpen && (
                <CardContent className="pt-0 animate-in slide-in-from-top-1 duration-200">
                    {children}
                </CardContent>
            )}
        </Card>
    );
}