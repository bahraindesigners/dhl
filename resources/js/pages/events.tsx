import NavbarLayout from '@/layouts/navbar-layout';
import { Head } from '@inertiajs/react';

export default function Events() {
    return (
        <NavbarLayout>
            <Head title="Events - DHL Bahraini Trade Union" />
            
            <div className="container mx-auto px-4 py-8">
                <div className="max-w-4xl mx-auto">
                    <h1 className="text-3xl font-bold text-foreground mb-6">Upcoming Events</h1>
                    
                    <div className="space-y-6">
                        <div className="border rounded-lg p-6">
                            <div className="flex flex-col md:flex-row md:items-center justify-between mb-4">
                                <h2 className="text-xl font-semibold text-foreground">Monthly Union Meeting</h2>
                                <span className="text-sm bg-primary/10 text-primary px-3 py-1 rounded-full">
                                    September 25, 2025
                                </span>
                            </div>
                            <p className="text-muted-foreground mb-4">
                                Join us for our monthly union meeting to discuss current issues, 
                                upcoming initiatives, and member concerns.
                            </p>
                            <div className="text-sm text-muted-foreground">
                                <p><strong>Time:</strong> 6:00 PM - 8:00 PM</p>
                                <p><strong>Location:</strong> DHL Conference Room A</p>
                            </div>
                        </div>
                        
                        <div className="border rounded-lg p-6">
                            <div className="flex flex-col md:flex-row md:items-center justify-between mb-4">
                                <h2 className="text-xl font-semibold text-foreground">Safety Training Workshop</h2>
                                <span className="text-sm bg-primary/10 text-primary px-3 py-1 rounded-full">
                                    October 2, 2025
                                </span>
                            </div>
                            <p className="text-muted-foreground mb-4">
                                Mandatory safety training session for all warehouse and logistics staff.
                                Learn about new safety protocols and emergency procedures.
                            </p>
                            <div className="text-sm text-muted-foreground">
                                <p><strong>Time:</strong> 9:00 AM - 12:00 PM</p>
                                <p><strong>Location:</strong> Training Center</p>
                            </div>
                        </div>
                        
                        <div className="border rounded-lg p-6">
                            <div className="flex flex-col md:flex-row md:items-center justify-between mb-4">
                                <h2 className="text-xl font-semibold text-foreground">Annual Union Picnic</h2>
                                <span className="text-sm bg-primary/10 text-primary px-3 py-1 rounded-full">
                                    October 15, 2025
                                </span>
                            </div>
                            <p className="text-muted-foreground mb-4">
                                Bring your family and join us for our annual union picnic! 
                                Food, games, and activities for all ages.
                            </p>
                            <div className="text-sm text-muted-foreground">
                                <p><strong>Time:</strong> 10:00 AM - 4:00 PM</p>
                                <p><strong>Location:</strong> Al Jazair Beach Resort</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}