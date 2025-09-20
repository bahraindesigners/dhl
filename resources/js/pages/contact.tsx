import NavbarLayout from '@/layouts/navbar-layout';
import { Head, Form } from '@inertiajs/react';

interface ContactSettings {
    instagram_url?: string;
    linkedin_url?: string;
    x_url?: string;
    office_address?: { en: string; ar: string };
    phone_numbers?: { en: string; ar: string };
    office_hours?: { en: string; ar: string };
    content?: { en: string; ar: string };
}

interface ContactProps {
    settings: ContactSettings;
}

export default function Contact({ settings }: ContactProps) {
    return (
        <NavbarLayout>
            <Head title="Contact - DHL Bahraini Union" />

            <div className="container mx-auto px-4 py-8 mb-16">
                <div className="max-w-4xl mx-auto">
                    <h1 className="text-3xl font-bold text-foreground mb-6">Contact Us</h1>

                    <div className="grid gap-8">
                        <div>
                            <h2 className="text-xl font-semibold text-foreground mb-4">Send us a Message</h2>
                            <Form
                                action="/contact"
                                method="post"
                                resetOnSuccess={true}
                            >
                                {({
                                    errors,
                                    hasErrors,
                                    processing,
                                    wasSuccessful,
                                    recentlySuccessful
                                }) => (
                                    <>
                                        {recentlySuccessful && (
                                            <div className="mb-4 p-4 bg-green-50 border border-green-200 rounded-md">
                                                <p className="text-green-800">
                                                    Thank you for your message! We will get back to you soon.
                                                </p>
                                            </div>
                                        )}

                                        <div className="space-y-4">
                                            <div>
                                                <label htmlFor="name" className="block text-sm font-medium text-foreground mb-1">
                                                    Name
                                                </label>
                                                <input
                                                    type="text"
                                                    id="name"
                                                    name="name"
                                                    className={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 ${errors.name ? 'border-red-500' : 'border-input'
                                                        }`}
                                                    placeholder="Your name"
                                                />
                                                {errors.name && (
                                                    <p className="mt-1 text-sm text-red-600">{errors.name}</p>
                                                )}
                                            </div>

                                            <div>
                                                <label htmlFor="email" className="block text-sm font-medium text-foreground mb-1">
                                                    Email
                                                </label>
                                                <input
                                                    type="email"
                                                    id="email"
                                                    name="email"
                                                    className={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 ${errors.email ? 'border-red-500' : 'border-input'
                                                        }`}
                                                    placeholder="your.email@example.com"
                                                />
                                                {errors.email && (
                                                    <p className="mt-1 text-sm text-red-600">{errors.email}</p>
                                                )}
                                            </div>

                                            <div>
                                                <label htmlFor="phone" className="block text-sm font-medium text-foreground mb-1">
                                                    Phone
                                                </label>
                                                <input
                                                    type="tel"
                                                    id="phone"
                                                    name="phone"
                                                    className={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 ${errors.phone ? 'border-red-500' : 'border-input'
                                                        }`}
                                                    placeholder="+973 1234 5678"
                                                />
                                                {errors.phone && (
                                                    <p className="mt-1 text-sm text-red-600">{errors.phone}</p>
                                                )}
                                            </div>

                                            <div>
                                                <label htmlFor="subject" className="block text-sm font-medium text-foreground mb-1">
                                                    Subject
                                                </label>
                                                <input
                                                    type="text"
                                                    id="subject"
                                                    name="subject"
                                                    className={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 ${errors.subject ? 'border-red-500' : 'border-input'
                                                        }`}
                                                    placeholder="Message subject"
                                                />
                                                {errors.subject && (
                                                    <p className="mt-1 text-sm text-red-600">{errors.subject}</p>
                                                )}
                                            </div>

                                            <div>
                                                <label htmlFor="message" className="block text-sm font-medium text-foreground mb-1">
                                                    Message
                                                </label>
                                                <textarea
                                                    id="message"
                                                    name="message"
                                                    rows={4}
                                                    className={`w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 ${errors.message ? 'border-red-500' : 'border-input'
                                                        }`}
                                                    placeholder="How can we help you?"
                                                ></textarea>
                                                {errors.message && (
                                                    <p className="mt-1 text-sm text-red-600">{errors.message}</p>
                                                )}
                                            </div>

                                            <button
                                                type="submit"
                                                disabled={processing}
                                                className="w-full bg-primary text-primary-foreground px-4 py-2 rounded-md hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            >
                                                {processing ? 'Sending...' : 'Send Message'}
                                            </button>
                                        </div>
                                    </>
                                )}
                            </Form>
                        </div>
                        <div>
                            <h2 className="text-xl font-semibold text-foreground mb-4">Get in Touch</h2>
                            <div className="space-y-4">
                                {settings?.office_address && (
                                    <div>
                                        <h3 className="font-medium text-foreground">Office Address</h3>
                                        <div
                                            className="text-muted-foreground"
                                            dangerouslySetInnerHTML={{
                                                __html: settings.office_address.en || settings.office_address.ar || ''
                                            }}
                                        />
                                    </div>
                                )}

                                {settings?.phone_numbers && (
                                    <div>
                                        <h3 className="font-medium text-foreground">Phone</h3>
                                        <p className="text-muted-foreground">
                                            {settings.phone_numbers.en || settings.phone_numbers.ar}
                                        </p>
                                    </div>
                                )}

                                {settings?.office_hours && (
                                    <div>
                                        <h3 className="font-medium text-foreground">Office Hours</h3>
                                        <div
                                            className="text-muted-foreground"
                                            dangerouslySetInnerHTML={{
                                                __html: settings.office_hours.en || settings.office_hours.ar || ''
                                            }}
                                        />
                                    </div>
                                )}

                                {settings?.content && (
                                    <div>
                                        <div
                                            className="text-muted-foreground prose prose-sm max-w-none"
                                            dangerouslySetInnerHTML={{
                                                __html: settings.content.en || settings.content.ar || ''
                                            }}
                                        />
                                    </div>
                                )}

                                {/* Social Media Links */}
                                {(settings?.instagram_url || settings?.linkedin_url || settings?.x_url) && (
                                    <div>
                                        <h3 className="font-medium text-foreground">Follow Us</h3>
                                        <div className="flex gap-4 mt-2">
                                            {settings?.instagram_url && (
                                                <a
                                                    href={settings.instagram_url}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="text-muted-foreground hover:text-primary transition-colors"
                                                    aria-label="Follow us on Instagram"
                                                >
                                                    <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                    </svg>
                                                </a>
                                            )}
                                            {settings?.linkedin_url && (
                                                <a
                                                    href={settings.linkedin_url}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="text-muted-foreground hover:text-primary transition-colors"
                                                    aria-label="Follow us on LinkedIn"
                                                >
                                                    <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                                    </svg>
                                                </a>
                                            )}
                                            {settings?.x_url && (
                                                <a
                                                    href={settings.x_url}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="text-muted-foreground hover:text-primary transition-colors"
                                                    aria-label="Follow us on X (Twitter)"
                                                >
                                                    <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                                    </svg>
                                                </a>
                                            )}
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </NavbarLayout>
    );
}