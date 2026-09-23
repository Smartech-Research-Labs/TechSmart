<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Services\AiBlogGeneratorService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateAiBlogPost extends Command
{
    protected $signature = 'blog:generate-ai-post {--force : Generate even if the automation toggle is off}';

    protected $description = 'Generate and publish one SEO-optimized AI blog post (runs Mondays & Thursdays via the scheduler)';

    public function handle(AiBlogGeneratorService $generator): int
    {
        $enabled = Setting::get('ai_blog_automation_enabled', '1') === '1';

        if (!$enabled && !$this->option('force')) {
            $this->info('AI blog automation is disabled (Settings > AI). Skipping. Use --force to override.');
            return self::SUCCESS;
        }

        try {
            $blog = $generator->generate();
            $this->info("Published: \"{$blog->title}\" (id {$blog->id}, category: {$blog->category})");
            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error('AI blog generation failed: ' . $e->getMessage());
            Log::error('AI blog generation command failed', ['error' => $e->getMessage()]);
            return self::FAILURE;
        }
    }
}
