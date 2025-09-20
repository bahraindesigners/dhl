<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use App\Models\ContactSetting;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        $settings = ContactSetting::getSingleton();

        // Get translations and convert content from TipTap JSON to HTML
        $contentTranslations = $settings->getTranslations('content');
        $processedContent = [];

        foreach ($contentTranslations as $locale => $content) {
            if (is_array($content)) {
                // Convert TipTap JSON to plain text or HTML
                $processedContent[$locale] = $this->extractTextFromTipTap($content);
            } else {
                $processedContent[$locale] = $content;
            }
        }

        return Inertia::render('contact', [
            'settings' => [
                'instagram_url' => $settings->instagram_url,
                'linkedin_url' => $settings->linkedin_url,
                'x_url' => $settings->x_url,
                'office_address' => $settings->getTranslations('office_address'),
                'phone_numbers' => $settings->getTranslations('phone_numbers'),
                'office_hours' => $settings->getTranslations('office_hours'),
                'content' => $processedContent,
            ],
        ]);
    }

    public function store(ContactFormRequest $request)
    {
        $contact = Contact::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // The ContactMessageCreated event will be automatically dispatched
        // by the Contact model's booted() method, which will trigger
        // the SendContactMessageNotification listener

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Extract plain text from TipTap JSON format
     */
    private function extractTextFromTipTap(array $content): string
    {
        $text = '';

        if (isset($content['content']) && is_array($content['content'])) {
            foreach ($content['content'] as $node) {
                $text .= $this->extractTextFromNode($node);
            }
        }

        return trim($text);
    }

    /**
     * Recursively extract text from TipTap node
     */
    private function extractTextFromNode(array $node): string
    {
        $text = '';

        if (isset($node['type'])) {
            if ($node['type'] === 'text' && isset($node['text'])) {
                $text .= $node['text'];
            } elseif ($node['type'] === 'paragraph') {
                if (isset($node['content']) && is_array($node['content'])) {
                    foreach ($node['content'] as $childNode) {
                        $text .= $this->extractTextFromNode($childNode);
                    }
                }
                $text .= "\n";
            } elseif (isset($node['content']) && is_array($node['content'])) {
                // Handle other node types with content
                foreach ($node['content'] as $childNode) {
                    $text .= $this->extractTextFromNode($childNode);
                }
            }
        }

        return $text;
    }
}
