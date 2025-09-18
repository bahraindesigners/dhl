import NavbarLayout from '@/layouts/navbar-layout';
import { Head } from '@inertiajs/react';

export default function News() {
    return (
        <NavbarLayout>
            <Head title="News - DHL Bahraini Trade Union" />
            
            <div className="container mx-auto px-4 py-8">
                <div className="max-w-4xl mx-auto">
                    <h1 className="text-3xl font-bold text-foreground mb-6">Latest News</h1>
                    
                    <div className="space-y-6">
                        <article className="border rounded-lg p-6">
                            <h2 className="text-xl font-semibold text-foreground mb-2">
                                Union Meeting Scheduled for Next Week
                            </h2>
                            <p className="text-sm text-muted-foreground mb-4">Posted on September 15, 2025</p>
                            <p className="text-muted-foreground">
                                Join us for our monthly union meeting to discuss upcoming initiatives 
                                and address member concerns. All members are welcome to attend.
                            </p>
                        </article>
                        
                        <article className="border rounded-lg p-6">
                            <h2 className="text-xl font-semibold text-foreground mb-2">
                                New Safety Protocols Implemented
                            </h2>
                            <p className="text-sm text-muted-foreground mb-4">Posted on September 10, 2025</p>
                            <p className="text-muted-foreground">
                                Enhanced safety measures have been put in place across all DHL facilities 
                                to ensure the wellbeing of our workforce.
                            </p>
                        </article>
                        
                        <article className="border rounded-lg p-6">
                            <h2 className="text-xl font-semibold text-foreground mb-2">
                                Training Opportunities Available
                            </h2>
                            <p className="text-sm text-muted-foreground mb-4">Posted on September 5, 2025</p>
                            <p className="text-muted-foreground">
                                New professional development programs are now available for union members. 
                                Contact us to learn more about eligibility and enrollment.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}