<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Union Loan Settings
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the Union Loan system including email
    | notifications, default values, and system behavior.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Administrator Notification Emails
    |--------------------------------------------------------------------------
    |
    | Email addresses that should receive notifications when new loan
    | applications are submitted. These users will be notified to
    | review and process loan applications.
    |
    */
    'admin_notification_emails' => [
        env('LOANS_ADMIN_EMAIL_1', 'admin@dhl.test'),
        env('LOANS_ADMIN_EMAIL_2', 'finance@dhl.test'),
        env('LOANS_ADMIN_EMAIL_3', 'hr@dhl.test'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Loan Settings
    |--------------------------------------------------------------------------
    |
    | Default configuration values for loan applications. These can be
    | overridden by the UnionLoanSettings model in the database.
    |
    */
    'defaults' => [
        'max_months' => env('LOANS_DEFAULT_MAX_MONTHS', 24),
        'is_active' => env('LOANS_DEFAULT_ACTIVE', true),
        'min_amount' => env('LOANS_MIN_AMOUNT', 100),
        'max_amount' => env('LOANS_MAX_AMOUNT', 10000),
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Notification Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for email notifications behavior.
    |
    */
    'notifications' => [
        // Whether to send email notifications for new loan applications
        'send_new_loan_notifications' => env('LOANS_SEND_NEW_NOTIFICATIONS', true),

        // Whether to send email notifications for loan status updates
        'send_status_update_notifications' => env('LOANS_SEND_UPDATE_NOTIFICATIONS', true),

        // Queue name for processing loan notification emails
        'queue' => env('LOANS_NOTIFICATION_QUEUE', 'default'),
    ],
];
