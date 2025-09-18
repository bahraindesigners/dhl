import NavbarLayout from '@/layouts/navbar-layout';
import { Head } from '@inertiajs/react';

export default function About() {
    return (
        <NavbarLayout>
            <Head title="About - DHL Bahraini Trade Union" />
            
            <div className="container mx-auto px-4 py-8">
                <div className="max-w-4xl mx-auto">
                    <h1 className="text-3xl font-bold text-foreground mb-6">About DHL Bahraini Trade Union</h1>
                    
                    <div className="prose prose-lg max-w-none">
                        <p className="text-muted-foreground mb-4">
                            Welcome to the DHL Bahraini Trade Union - your voice in the workplace, 
                            your partner in progress.
                        </p>
                        
                        <h2 className="text-2xl font-semibold text-foreground mt-8 mb-4">Our Mission</h2>
                        <p className="text-muted-foreground mb-4">
                            To represent and protect the rights and interests of all DHL employees in Bahrain, 
                            ensuring fair treatment, safe working conditions, and opportunities for professional growth.
                        </p>
                        
                        <h2 className="text-2xl font-semibold text-foreground mt-8 mb-4">Our Values</h2>
                        <ul className="list-disc list-inside text-muted-foreground space-y-2">
                            <li>Unity in strength</li>
                            <li>Fairness and equality</li>
                            <li>Professional development</li>
                            <li>Workplace safety</li>
                            <li>Mutual respect</li>
                        </ul>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}