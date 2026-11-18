<?php

namespace App\Mail;

use App\Models\Blog;
use App\Services\SiteSeo;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** Tells the admin inbox that a scheduled blog post was published, or could not be. */
class BlogAutomationAlert extends Mailable
{
    public function __construct(public ?Blog $blog = null, public ?string $failure = null) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->blog
                ? "New blog post published: {$this->blog->title}"
                : 'Action needed: scheduled blog post was not published',
        );
    }

    public function content(): Content
    {
        $base = SiteSeo::baseUrl();

        return new Content(
            view: 'emails.blog-automation-alert',
            with: [
                'postUrl' => $this->blog ? "{$base}/blog/{$this->blog->slug}" : null,
                'adminUrl' => "{$base}/admin/blogs",
                'wordCount' => $this->blog ? str_word_count(strip_tags($this->blog->content)) : 0,
                'linkCount' => $this->blog ? substr_count($this->blog->content, '<a ') : 0,
            ],
        );
    }
}
