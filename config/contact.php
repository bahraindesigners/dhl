<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Contact Form Settings
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the contact form including email
    | notifications and system behavior.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Email Notification Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for email notifications behavior when contact
    | messages are submitted.
    |
    */
    'notifications' => [
        // Whether to send email notifications for new contact messages
        'send_notifications' => env('CONTACT_SEND_NOTIFICATIONS', true),
        
        // Whether to queue the notification emails
        'queue_enabled' => env('CONTACT_QUEUE_ENABLED', false),
        
        // Queue name for processing contact notification emails
        'queue' => env('CONTACT_NOTIFICATION_QUEUE', 'default'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Settings to prevent spam and abuse of the contact form.
    |
    */
    'rate_limiting' => [
        // Maximum contact messages per IP per hour
        'max_per_hour' => env('CONTACT_MAX_PER_HOUR', 5),
        
        // Maximum contact messages per email per day
        'max_per_email_per_day' => env('CONTACT_MAX_PER_EMAIL_PER_DAY', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Settings
    |--------------------------------------------------------------------------
    |
    | Additional validation and filtering settings.
    |
    */
    'validation' => [
        // Whether to validate email domains against common disposable email providers
        'block_disposable_emails' => env('CONTACT_BLOCK_DISPOSABLE_EMAILS', false),
        
        // Minimum message length (characters)
        'min_message_length' => env('CONTACT_MIN_MESSAGE_LENGTH', 10),
        
        // Maximum message length (characters)
        'max_message_length' => env('CONTACT_MAX_MESSAGE_LENGTH', 5000),
    ],
];