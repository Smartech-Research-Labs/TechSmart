<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New {{ $typeLabel }}</title>
</head>
<body style="margin:0;padding:24px;background:#f4f4f7;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
        <tr>
            <td style="background:#0f172a;padding:20px 28px;">
                <p style="margin:0;color:#d311f5;font-size:12px;letter-spacing:2px;text-transform:uppercase;font-weight:bold;">{{ config('mail.from.name') }}</p>
                <h1 style="margin:6px 0 0;color:#ffffff;font-size:20px;">New {{ $typeLabel }}</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:24px 28px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;line-height:1.6;">
                    <tr><td style="color:#6b7280;width:130px;padding:4px 0;">Name</td><td style="padding:4px 0;"><strong>{{ $enquiry->name }}</strong></td></tr>
                    <tr><td style="color:#6b7280;padding:4px 0;">Email</td><td style="padding:4px 0;"><a href="mailto:{{ $enquiry->email }}" style="color:#2563eb;">{{ $enquiry->email }}</a></td></tr>
                    @if ($enquiry->phone)
                        <tr><td style="color:#6b7280;padding:4px 0;">Phone</td><td style="padding:4px 0;"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $enquiry->phone) }}" style="color:#2563eb;">{{ $enquiry->phone }}</a></td></tr>
                    @endif
                    @if ($enquiry->company)
                        <tr><td style="color:#6b7280;padding:4px 0;">Company</td><td style="padding:4px 0;">{{ $enquiry->company }}</td></tr>
                    @endif
                    @if ($enquiry->subject)
                        <tr><td style="color:#6b7280;padding:4px 0;">Subject</td><td style="padding:4px 0;">{{ $enquiry->subject }}</td></tr>
                    @endif
                    @foreach (($enquiry->form_data ?? []) as $key => $value)
                        @if (!is_null($value) && $value !== '' && $key !== 'subject')
                            <tr><td style="color:#6b7280;padding:4px 0;">{{ ucwords(str_replace('_', ' ', $key)) }}</td><td style="padding:4px 0;">{{ is_array($value) ? implode(', ', $value) : $value }}</td></tr>
                        @endif
                    @endforeach
                    <tr><td style="color:#6b7280;padding:4px 0;">Received</td><td style="padding:4px 0;">{{ $enquiry->created_at?->timezone('Africa/Nairobi')->format('D, j M Y \a\t g:i A') }} (EAT)</td></tr>
                </table>

                @if ($enquiry->message)
                    <p style="margin:20px 0 6px;color:#6b7280;font-size:13px;text-transform:uppercase;letter-spacing:1px;">Message</p>
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:14px 16px;font-size:14px;line-height:1.6;white-space:pre-wrap;">{{ $enquiry->message }}</div>
                @endif

                <p style="margin:24px 0 0;">
                    <a href="mailto:{{ $enquiry->email }}" style="display:inline-block;background:#d311f5;color:#ffffff;text-decoration:none;padding:10px 18px;border-radius:999px;font-size:14px;font-weight:bold;">Reply to {{ $enquiry->name }}</a>
                    <a href="{{ $adminUrl }}" style="display:inline-block;margin-left:8px;color:#2563eb;font-size:14px;">View in admin</a>
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding:14px 28px;border-top:1px solid #e5e7eb;color:#9ca3af;font-size:12px;">
                Sent from the website contact form. Replying to this email goes straight to the customer.
            </td>
        </tr>
    </table>
</body>
</html>
