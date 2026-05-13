<?php

namespace App\Services;

use OpenAI\Client;
use OpenAI\Factory;
use Illuminate\Support\Facades\Log;

class AISeoBulkUpdateService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = Factory::make(config('services.openai.key'));
    }

    /**
     * Generate SEO metadata for multiple images
     */
    public function generateBulkMetadata(array $images, ?string $context = null): array
    {
        $results = [];

        foreach ($images as $image) {
            try {
                $metadata = $this->generateMetadata($image, $context);
                $results[] = [
                    'id' => $image['id'],
                    'success' => true,
                    'data' => $metadata,
                ];
            } catch (\Exception $e) {
                Log::error('SEO metadata generation failed', [
                    'image_id' => $image['id'],
                    'error' => $e->getMessage(),
                ]);
                $results[] = [
                    'id' => $image['id'],
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    /**
     * Generate SEO metadata for a single image
     */
    public function generateMetadata(array $image, ?string $context = null): array
    {
        $prompt = $this->buildPrompt($image, $context);

        $response = $this->client->chat()->create([
            'model' => 'gpt-4-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an expert SEO copywriter and web accessibility specialist. Generate SEO-optimized metadata for images that improves search rankings and accessibility.',
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'temperature' => 0.7,
            'max_tokens' => 500,
            'response_format' => ['type' => 'json_object'],
        ]);

        $content = $response->choices[0]->message->content;
        $parsed = json_decode($content, true);

        return [
            'title' => $parsed['title'] ?? '',
            'description' => $parsed['description'] ?? '',
            'alt_text' => $parsed['alt_text'] ?? '',
            'caption' => $parsed['caption'] ?? '',
        ];
    }

    /**
     * Build the prompt for AI metadata generation
     */
    protected function buildPrompt(array $image, ?string $context = null): string
    {
        $context = $context ? "Context: {$context}\n" : "";
        $filename = $image['name'] ?? $image['path'] ?? 'Unknown image';
        
        return <<<PROMPT
Generate SEO-optimized metadata for the following image:

Filename: {$filename}
{$context}

Return a JSON object with these exact fields:
{
  "title": "SEO-optimized title (max 60 characters, include primary keywords)",
  "description": "SEO description for the image (max 160 characters, describe what's in the image and why it matters)",
  "alt_text": "Descriptive alt text (max 125 characters, for accessibility and SEO, be specific about what's shown)",
  "caption": "Image caption (2-3 sentences, explain context and importance for web accessibility)"
}

Guidelines:
- Include relevant keywords naturally
- Make alt_text descriptive and accessible
- Ensure descriptions are unique and specific
- Focus on user benefit and relevance
- Avoid keyword stuffing
- Write for both search engines and accessibility
PROMPT;
    }

    /**
     * Generate metadata for images with industry context
     */
    public function generateForIndustry(array $images, string $industryTitle, string $industryDescription): array
    {
        $context = "This image is for the '{$industryTitle}' industry section. Industry focuses on: {$industryDescription}";
        return $this->generateBulkMetadata($images, $context);
    }

    /**
     * Generate metadata for service images
     */
    public function generateForServices(array $images): array
    {
        $context = 'These are service/product images for a technology company. Focus on professional, business-oriented descriptions.';
        return $this->generateBulkMetadata($images, $context);
    }
}
