import NavbarLayout from '@/layouts/navbar-layout';
import { Head } from '@inertiajs/react';

export default function Resources() {
    return (
        <NavbarLayout>
            <Head title="Resources - DHL Bahraini Trade Union" />
            
            <div className="container mx-auto px-4 py-8">
                <div className="max-w-4xl mx-auto">
                    <h1 className="text-3xl font-bold text-foreground mb-6">Resources</h1>
                    
                    <div className="grid md:grid-cols-2 gap-6">
                        <div className="border rounded-lg p-6">
                            <h2 className="text-xl font-semibold text-foreground mb-4">Documents & Forms</h2>
                            <ul className="space-y-3">
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Union Membership Application
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Grievance Filing Form
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Safety Incident Report
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Training Request Form
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div className="border rounded-lg p-6">
                            <h2 className="text-xl font-semibold text-foreground mb-4">Policies & Guidelines</h2>
                            <ul className="space-y-3">
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Union Constitution
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Member Rights & Responsibilities
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Workplace Safety Guidelines
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Collective Bargaining Agreement
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div className="border rounded-lg p-6">
                            <h2 className="text-xl font-semibold text-foreground mb-4">Training Materials</h2>
                            <ul className="space-y-3">
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Leadership Development Program
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Safety Training Modules
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Professional Skills Workshops
                                    </a>
                                </li>
                                <li>
                                    <a href="#" className="text-primary hover:text-primary/80 underline">
                                        Online Learning Portal
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <div className="border rounded-lg p-6">
                            <h2 className="text-xl font-semibold text-foreground mb-4">Contact Information</h2>
                            <div className="space-y-3">
                                <div>
                                    <h3 className="font-medium text-foreground">Union President</h3>
                                    <p className="text-muted-foreground text-sm">president@dhlunion.bh</p>
                                </div>
                                <div>
                                    <h3 className="font-medium text-foreground">HR Liaison</h3>
                                    <p className="text-muted-foreground text-sm">hr@dhlunion.bh</p>
                                </div>
                                <div>
                                    <h3 className="font-medium text-foreground">Safety Officer</h3>
                                    <p className="text-muted-foreground text-sm">safety@dhlunion.bh</p>
                                </div>
                                <div>
                                    <h3 className="font-medium text-foreground">General Inquiries</h3>
                                    <p className="text-muted-foreground text-sm">info@dhlunion.bh</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}