<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $blog ? 'New blog post published' : 'Blog post not published' }}</title>
</head>
<body style="margin:0;padding:24px;background:#f4f4f7;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:10px;overflow:hidden;">
        <tr>
            <td style="background:#0f172a;padding:20px 28px;">
                <p style="margin:0;color:#d311f5;font-size:12px;letter-spacing:2px;text-transform:uppercase;font-weight:bold;">OmniviaTech Blog</p>
                <h1 style="margin:6px 0 0;color:#ffffff;font-size:20px;">{{ $blog ? 'New post published' : 'Scheduled post not published' }}</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:24px 28px;font-size:14px;line-height:1.6;">
                @if ($blog)
                    <h2 style="margin:0 0 8px;font-size:18px;color:#111827;">{{ $blog->title }}</h2>
                    <p style="margin:0 0 16px;color:#4b5563;">{{ $blog->excerpt }}</p>
                    <p style="margin:0 0 20px;color:#6b7280;">
                        Category: {{ $blog->category }}<br>
                        Length: about {{ number_format($wordCount) }} words<br>
                        Internal links: {{ $linkCount }}
                    </p>
                    <a href="{{ $postUrl }}" style="display:inline-block;background:#d311f5;color:#ffffff;text-decoration:none;font-weight:bold;padding:10px 18px;border-radius:6px;">Read the post</a>
                    <a href="{{ $adminUrl }}" style="display:inline-block;margin-left:12px;color:#3b82f6;">Edit in admin</a>
                @else
                    <p style="margin:0 0 12px;">The automatic blog post could not be published after all attempts today.</p>
                    <p style="margin:0 0 16px;padding:12px;background:#fef2f2;color:#991b1b;border-radius:6px;">{{ $failure }}</p>
                    <p style="margin:0;">Check the AI provider key and account credit under Settings &gt; AI. You can publish a post from there with Generate now.</p>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
