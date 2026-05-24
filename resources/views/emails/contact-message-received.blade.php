<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>New project brief from {{ $contactMessage->name }}</title>
    </head>
    <body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; line-height: 1.6; color: #111;">
        <h1 style="font-size: 18px; font-weight: 600;">New project brief from {{ $contactMessage->name }}</h1>

        <p style="font-size: 14px; color: #444;">
            Submitted via <a href="{{ url('/contact') }}">akhirrijal.my.id/contact</a> on
            {{ $contactMessage->created_at?->toDayDateTimeString() }}.
        </p>

        <table cellpadding="6" cellspacing="0" style="border-collapse: collapse; margin-top: 16px; font-size: 14px;">
            <tr>
                <td style="font-weight: 600; vertical-align: top;">Name</td>
                <td>{{ $contactMessage->name }}</td>
            </tr>
            <tr>
                <td style="font-weight: 600; vertical-align: top;">Email</td>
                <td><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></td>
            </tr>
            <tr>
                <td style="font-weight: 600; vertical-align: top;">Subject</td>
                <td>{{ $contactMessage->subject }}</td>
            </tr>
            <tr>
                <td style="font-weight: 600; vertical-align: top;">IP / UA</td>
                <td style="color: #666;">{{ $contactMessage->ip_address ?? '—' }}<br />{{ $contactMessage->user_agent ?? '—' }}</td>
            </tr>
        </table>

        <h2 style="font-size: 16px; font-weight: 600; margin-top: 24px;">Message</h2>
        <p style="white-space: pre-wrap;">{{ $contactMessage->message }}</p>

        <hr style="margin-top: 32px; border: 0; border-top: 1px solid #ddd;" />
        <p style="font-size: 12px; color: #999;">
            Contact message #{{ $contactMessage->id }} · open in admin: {{ url('/admin/contact-messages/'.$contactMessage->id.'/edit') }}
        </p>
    </body>
</html>
