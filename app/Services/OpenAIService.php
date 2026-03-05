<?php

namespace App\Services;

use OpenAI;
use Exception;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        if (!config('services.openai.key')) {
            throw new Exception('OpenAI API key not configured');
        }

        $this->client = OpenAI::client(config('services.openai.key'));
    }

    /**
     * Generate content suggestions for services/products
     *
     * @param string $title
     * @param string $category
     * @param string $contentType (description|features|benefits)
     * @return string
     */
    public function generateContentSuggestion(string $title, string $category, string $contentType = 'description'): string
    {
        try {
            $prompts = [
                'description' => "Write a compelling 2-3 sentence description for a tech service/product called '{$title}' in the {$category} category. Make it professional and engaging.",
                'features' => "List 5 key features for a tech service/product called '{$title}' in the {$category} category. Return as a JSON array of strings.",
                'benefits' => "List 3 main benefits customers will get from '{$title}', a tech service/product in the {$category} category. Make it customer-focused.",
            ];

            $response = $this->client->chat()->create([
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a professional tech copywriter specializing in B2B and enterprise technology content.'],
                    ['role' => 'user', 'content' => $prompts[$contentType] ?? $prompts['description']],
                ],
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

            $content = $response->choices[0]->message->content;

            Log::info('OpenAI content generated', [
                'title' => $title,
                'type' => $contentType,
                'length' => strlen($content),
            ]);

            return $content;

        } catch (Exception $e) {
            Log::error('OpenAI content generation failed', [
                'error' => $e->getMessage(),
                'title' => $title,
            ]);
            throw new Exception('Failed to generate content: ' . $e->getMessage());
        }
    }

    /**
     * Generate SEO meta tags (title, description, keywords)
     *
     * @param string $content
     * @param string $title
     * @return array
     */
    public function generateSEO(string $content, string $title): array
    {
        try {
            $prompt = "Given this content: \"{$content}\"\n\nGenerate SEO-optimized:\n1. Meta description (max 160 characters)\n2. 5 relevant keywords\n\nRespond in JSON format: {\"meta_description\": \"\", \"keywords\": []}";

            $response = $this->client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an SEO expert. Always respond with valid JSON.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.5,
                'max_tokens' => 200,
            ]);

            $result = json_decode($response->choices[0]->message->content, true);

            if (!$result) {
                throw new Exception('Invalid JSON response from OpenAI');
            }

            Log::info('OpenAI SEO generated', ['title' => $title]);

            return [
                'meta_title' => strlen($title) > 60 ? substr($title, 0, 57) . '...' : $title,
                'meta_description' => $result['meta_description'] ?? '',
                'keywords' => implode(', ', $result['keywords'] ?? []),
            ];

        } catch (Exception $e) {
            Log::error('OpenAI SEO generation failed', [
                'error' => $e->getMessage(),
                'title' => $title,
            ]);
            throw new Exception('Failed to generate SEO: ' . $e->getMessage());
        }
    }

    /**
     * Analyze review sentiment
     *
     * @param string $reviewText
     * @return array ['sentiment' => 'positive|neutral|negative', 'score' => float, 'summary' => string]
     */
    public function analyzeReviewSentiment(string $reviewText): array
    {
        try {
            $response = $this->client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Analyze the sentiment of customer reviews. Respond with JSON: {"sentiment": "positive|neutral|negative", "score": 0.0-1.0, "summary": "one sentence summary"}'
                    ],
                    ['role' => 'user', 'content' => $reviewText],
                ],
                'temperature' => 0.3,
                'max_tokens' => 150,
            ]);

            $result = json_decode($response->choices[0]->message->content, true);

            if (!$result) {
                // Fallback if JSON parsing fails
                return [
                    'sentiment' => 'neutral',
                    'score' => 0.5,
                    'summary' => 'Unable to analyze sentiment',
                ];
            }

            Log::info('OpenAI sentiment analyzed', [
                'sentiment' => $result['sentiment'] ?? 'unknown',
                'score' => $result['score'] ?? 0,
            ]);

            return [
                'sentiment' => $result['sentiment'] ?? 'neutral',
                'score' => (float) ($result['score'] ?? 0.5),
                'summary' => $result['summary'] ?? '',
            ];

        } catch (Exception $e) {
            Log::error('OpenAI sentiment analysis failed', [
                'error' => $e->getMessage(),
            ]);

            return [
                'sentiment' => 'neutral',
                'score' => 0.5,
                'summary' => 'Analysis unavailable',
            ];
        }
    }

    /**
     * AI chatbot response when no admin is online
     *
     * @param string $userMessage
     * @param array $context Previous messages [['role' => 'user|assistant', 'content' => '']]
     * @param array $companyInfo Company details for context
     * @return string
     */
    public function chatbotResponse(string $userMessage, array $context = [], array $companyInfo = []): string
    {
        try {
            $companyName = $companyInfo['name'] ?? 'Smartech Research Labs';
            $companyServices = $companyInfo['services'] ?? 'web development, mobile apps, cloud solutions';

            $systemPrompt = "You are a helpful customer support assistant for {$companyName}, a technology company. 

Our services include: {$companyServices}.

Answer customer questions professionally. If you don't know something specific, suggest they wait for a human agent or provide the contact email. Keep responses concise (2-3 sentences max).";

            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
            ];

            // Add conversation context (last 10 messages)
            $recentContext = array_slice($context, -10);
            foreach ($recentContext as $msg) {
                $messages[] = [
                    'role' => $msg['role'],
                    'content' => $msg['content'],
                ];
            }

            // Add current user message
            $messages[] = ['role' => 'user', 'content' => $userMessage];

            $response = $this->client->chat()->create([
                'model' => 'gpt-4',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 300,
            ]);

            $botResponse = $response->choices[0]->message->content;

            Log::info('OpenAI chatbot response generated', [
                'message_length' => strlen($userMessage),
                'response_length' => strlen($botResponse),
            ]);

            return $botResponse;

        } catch (Exception $e) {
            Log::error('OpenAI chatbot response failed', [
                'error' => $e->getMessage(),
            ]);

            return "I apologize, but I'm temporarily unable to assist. Please wait for one of our human agents to join the chat, or email us at support@smartechresearchlabs.co.ke.";
        }
    }

    /**
     * Generate process steps for a service
     *
     * @param string $serviceTitle
     * @param string $category
     * @return array
     */
    public function generateProcessSteps(string $serviceTitle, string $category): array
    {
        try {
            $prompt = "Generate 4-6 process steps for delivering a tech service called '{$serviceTitle}' in the {$category} category. 

Return as JSON array: [{\"step\": 1, \"title\": \"Discovery\", \"description\": \"Brief description\"}]";

            $response = $this->client->chat()->create([
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a business process expert. Always respond with valid JSON.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.6,
                'max_tokens' => 600,
            ]);

            $result = json_decode($response->choices[0]->message->content, true);

            if (!$result || !is_array($result)) {
                throw new Exception('Invalid JSON response');
            }

            Log::info('OpenAI process steps generated', [
                'service' => $serviceTitle,
                'steps_count' => count($result),
            ]);

            return $result;

        } catch (Exception $e) {
            Log::error('OpenAI process steps generation failed', [
                'error' => $e->getMessage(),
            ]);

            // Return fallback process steps
            return [
                ['step' => 1, 'title' => 'Consultation', 'description' => 'Initial discussion of requirements'],
                ['step' => 2, 'title' => 'Planning', 'description' => 'Strategic planning and design'],
                ['step' => 3, 'title' => 'Implementation', 'description' => 'Building and development'],
                ['step' => 4, 'title' => 'Delivery', 'description' => 'Testing and deployment'],
            ];
        }
    }

    /**
     * Improve existing text (grammar, clarity, professionalism)
     *
     * @param string $text
     * @return string
     */
    public function improveText(string $text): string
    {
        try {
            $response = $this->client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an editor. Improve the given text for grammar, clarity, and professionalism. Keep the same tone and length. Return only the improved text.'
                    ],
                    ['role' => 'user', 'content' => $text],
                ],
                'temperature' => 0.5,
                'max_tokens' => strlen($text) + 200,
            ]);

            return $response->choices[0]->message->content;

        } catch (Exception $e) {
            Log::error('OpenAI text improvement failed', [
                'error' => $e->getMessage(),
            ]);

            return $text; // Return original if fails
        }
    }
}
