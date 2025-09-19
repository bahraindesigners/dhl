<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: #1e40af;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }
        .field-value {
            color: #6b7280;
            background: #f9fafb;
            padding: 10px;
            border-radius: 4px;
            border-left: 4px solid #1e40af;
        }
        .message-content {
            white-space: pre-wrap;
            line-height: 1.6;
        }
        .footer {
            background: #f3f4f6;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">New Contact Message</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">DHL Bahraini Trade Union</p>
        </div>
        
        <div class="content">
            <div class="field">
                <div class="field-label">Name:</div>
                <div class="field-value">{{ $contact->name }}</div>
            </div>
            
            <div class="field">
                <div class="field-label">Email:</div>
                <div class="field-value">
                    <a href="mailto:{{ $contact->email }}" style="color: #1e40af; text-decoration: none;">
                        {{ $contact->email }}
                    </a>
                </div>
            </div>
            
            @if($contact->phone)
            <div class="field">
                <div class="field-label">Phone:</div>
                <div class="field-value">
                    <a href="tel:{{ $contact->phone }}" style="color: #1e40af; text-decoration: none;">
                        {{ $contact->phone }}
                    </a>
                </div>
            </div>
            @endif
            
            @if($contact->subject)
            <div class="field">
                <div class="field-label">Subject:</div>
                <div class="field-value">{{ $contact->subject }}</div>
            </div>
            @endif
            
            <div class="field">
                <div class="field-label">Message:</div>
                <div class="field-value">
                    <div class="message-content">{{ $contact->message }}</div>
                </div>
            </div>
            
            <div class="field">
                <div class="field-label">Received At:</div>
                <div class="field-value">{{ $contact->created_at->format('F j, Y g:i A') }}</div>
            </div>
            
            @if($contact->ip_address)
            <div class="field">
                <div class="field-label">IP Address:</div>
                <div class="field-value">{{ $contact->ip_address }}</div>
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p>This message was sent from the contact form on your website.</p>
            <p>Please reply directly to the sender's email address.</p>
        </div>
    </div>
</body>
</html>