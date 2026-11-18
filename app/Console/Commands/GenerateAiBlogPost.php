<?php

namespace App\Console\Commands;

use App\Mail\BlogAutomationAlert;
use App\Models\Setting;
use App\Services\AiBlogGeneratorService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class GenerateAiBlogPost extends Command
{
    protected $signature = 'blog:generate-ai-post
        {--force : Generate even if automation is off or a post already went out today}
        {--dry-run : Generate and check a post without saving or emailing anything}';

    protected $description = 'Generate and publish one SEO blog post (scheduled for Mondays and Thursdays)';

    public function handle(AiBlogGeneratorService $generator): int
    {
        $today = now('Africa/Nairobi')->toDateString();
        $force = (bool) $this->option('force');
        $dryRun = (bool) $this->option('dry-run');

        if (!$dryRun && !$force) {
            if (Setting::get('ai_blog_automation_enabled', '1') !== '1') {
                $this->info('AI blog automation is disabled (Settings > AI). Skipping.');
                return self::SUCCESS;
            }

            // The schedule retries later in the day, so a finished day must do nothing.
            if (Setting::get('ai_blog_last_published_on') === $today) {
                $this->info('A post was already published today. Skipping.');
                return self::SUCCESS;
            }
        }

        try {
            if ($dryRun) {
                $draft = $generator->draft();
                $this->info("Draft OK: \"{$draft['title']}\"");
                $this->line("Category: {$draft['category']}");
                $this->line("Words: {$draft['word_count']}");
                $this->line('Internal links: ' . implode(', ', $draft['internal_links']));
                $this->line("SEO title: {$draft['seo_title']}");
                $this->line("SEO description: {$draft['seo_description']}");
                return self::SUCCESS;
            }

            $blog = $generator->generate();
            Setting::set('ai_blog_last_published_on', $today, 'ai');
            $this->info("Published: \"{$blog->title}\" (id {$blog->id}, category: {$blog->category})");

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('AI blog generation failed: ' . $e->getMessage());
            Log::error('AI blog generation command failed', ['error' => $e->getMessage()]);

            if (!$dryRun) {
                $this->alertFailureOncePerDay($today, $e->getMessage());
            }

            return self::FAILURE;
        }
    }

    protected function alertFailureOncePerDay(string $today, string $error): void
    {
        if (Setting::get('ai_blog_last_failure_alert') === $today) {
            return;
        }

        try {
            Mail::to(config('mail.blog_alerts_to'))->send(new BlogAutomationAlert(failure: $error));
            Setting::set('ai_blog_last_failure_alert', $today, 'ai');
        } catch (Throwable $e) {
            Log::error('Blog failure alert could not be sent', ['error' => $e->getMessage()]);
        }
    }
}
