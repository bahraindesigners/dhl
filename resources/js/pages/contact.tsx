import NavbarLayout from '@/layouts/navbar-layout';
import { Head } from '@inertiajs/react';

export default function Contact() {
    return (
        <NavbarLayout>
            <Head title="Contact - DHL Bahraini Trade Union" />
            
            <div className="container mx-auto px-4 py-8">
                <div className="max-w-4xl mx-auto">
                    <h1 className="text-3xl font-bold text-foreground mb-6">Contact Us</h1>
                    
                    <div className="grid md:grid-cols-2 gap-8">
                        <div>
                            <h2 className="text-xl font-semibold text-foreground mb-4">Get in Touch</h2>
                            <div className="space-y-4">
                                <div>
                                    <h3 className="font-medium text-foreground">Office Address</h3>
                                    <p className="text-muted-foreground">
                                        DHL Bahrain<br />
                                        Building 123, Industrial Area<br />
                                        Manama, Kingdom of Bahrain
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 className="font-medium text-foreground">Phone</h3>
                                    <p className="text-muted-foreground">+973 1234 5678</p>
                                </div>
                                
                                <div>
                                    <h3 className="font-medium text-foreground">Email</h3>
                                    <p className="text-muted-foreground">info@dhlunion.bh</p>
                                </div>
                                
                                <div>
                                    <h3 className="font-medium text-foreground">Office Hours</h3>
                                    <p className="text-muted-foreground">
                                        Sunday - Thursday: 8:00 AM - 5:00 PM<br />
                                        Friday - Saturday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h2 className="text-xl font-semibold text-foreground mb-4">Send us a Message</h2>
                            <form className="space-y-4">
                                <div>
                                    <label htmlFor="name" className="block text-sm font-medium text-foreground mb-1">
                                        Name
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        className="w-full px-3 py-2 border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50"
                                        placeholder="Your name"
                                    />
                                </div>
                                
                                <div>
                                    <label htmlFor="email" className="block text-sm font-medium text-foreground mb-1">
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        className="w-full px-3 py-2 border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50"
                                        placeholder="your.email@example.com"
                                    />
                                </div>
                                
                                <div>
                                    <label htmlFor="message" className="block text-sm font-medium text-foreground mb-1">
                                        Message
                                    </label>
                                    <textarea
                                        id="message"
                                        rows={4}
                                        className="w-full px-3 py-2 border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50"
                                        placeholder="How can we help you?"
                                    ></textarea>
                                </div>
                                
                                <button
                                    type="submit"
                                    className="w-full bg-primary text-primary-foreground px-4 py-2 rounded-md hover:bg-primary/90 transition-colors"
                                >
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}