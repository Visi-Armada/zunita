<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $notification->title }}</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #0f1419;
            margin: 0;
            padding: 0;
            background-color: #f3f2f1;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #0f1419 0%, #1f4e79 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .header h1 {
            font-family: 'Georgia', serif;
            font-size: 1.75rem;
            font-weight: 400;
            margin: 0;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.875rem;
        }
        
        .content {
            padding: 2rem;
        }
        
        .notification-title {
            font-family: 'Georgia', serif;
            font-size: 1.5rem;
            color: #1f4e79;
            margin-bottom: 1rem;
            font-weight: 400;
        }
        
        .notification-message {
            color: #6e6e6e;
            margin-bottom: 2rem;
            font-size: 1rem;
        }
        
        .priority-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }
        
        .priority-normal {
            background-color: #0078d4;
            color: white;
        }
        
        .priority-high {
            background-color: #ff8c00;
            color: white;
        }
        
        .priority-urgent {
            background-color: #d13438;
            color: white;
        }
        
        .priority-low {
            background-color: #6e6e6e;
            color: white;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #ffb900;
            color: #0f1419;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            margin-top: 1rem;
            transition: background-color 0.2s;
        }
        
        .cta-button:hover {
            background-color: #e6a700;
        }
        
        .footer {
            background-color: #f3f2f1;
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid #e1e0df;
        }
        
        .footer p {
            margin: 0;
            color: #6e6e6e;
            font-size: 0.875rem;
        }
        
        .footer a {
            color: #1f4e79;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .metadata {
            background-color: #f8f9fa;
            border: 1px solid #e1e0df;
            border-radius: 4px;
            padding: 1rem;
            margin-top: 1.5rem;
        }
        
        .metadata h4 {
            margin: 0 0 0.5rem 0;
            color: #1f4e79;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .metadata p {
            margin: 0;
            color: #6e6e6e;
            font-size: 0.875rem;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 0;
                box-shadow: none;
            }
            
            .header, .content, .footer {
                padding: 1rem;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
            
            .notification-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>YB Dato' Zunita Begum</h1>
            <p>Official Communication from Pilah Constituency Office</p>
        </div>
        
        <div class="content">
            <div class="priority-badge priority-{{ $notification->priority }}">
                {{ ucfirst($notification->priority) }} Priority
            </div>
            
            <h2 class="notification-title">{{ $notification->title }}</h2>
            
            <div class="notification-message">
                {!! nl2br(e($notification->message)) !!}
            </div>
            
            @if(isset($notification->template_data['cta_url']) && isset($notification->template_data['cta_text']))
                <a href="{{ $notification->template_data['cta_url'] }}" class="cta-button">
                    {{ $notification->template_data['cta_text'] }}
                </a>
            @endif
            
            <div class="metadata">
                <h4>Notification Details</h4>
                <p><strong>Type:</strong> {{ ucfirst($notification->type) }}</p>
                <p><strong>Sent:</strong> {{ $notification->sent_at ? $notification->sent_at->format('F j, Y \a\t g:i A') : 'Now' }}</p>
                @if($notification->scheduled_at)
                    <p><strong>Scheduled for:</strong> {{ $notification->scheduled_at->format('F j, Y \a\t g:i A') }}</p>
                @endif
            </div>
        </div>
        
        <div class="footer">
            <p>
                This is an official communication from YB Dato' Zunita Begum's office.<br>
                If you have any questions, please contact us at 
                <a href="mailto:info@zunitabegum.my">info@zunitabegum.my</a>
            </p>
            <p style="margin-top: 1rem;">
                <a href="{{ url('/unsubscribe') }}?token={{ $delivery->id }}">Unsubscribe from notifications</a>
            </p>
        </div>
    </div>
</body>
</html>
