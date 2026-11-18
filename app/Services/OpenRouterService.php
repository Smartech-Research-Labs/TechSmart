<?php

namespace App\Services;

use App\Contracts\AiTextGenerator;
use App\Exceptions\AiProviderUnavailable;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/** Free backup provider. The default model routes each request to a free model. */
class OpenRouterService implements AiTextGenerator
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $key = config('services.openrouter.key');

        if (!$key) {
            throw new AiProviderUnavailable('OpenRouter API key not configured');
        }

        $this->apiKey = $key;
        $this->model = config('services.openrouter.model');

        if ($this->model !== 'openrouter/free' && !str_ends_with($this->model, ':free')) {
            throw new AiProviderUnavailable('OPENROUTER_MODEL must be a free model');
        }
    }

    public function chatJson(string $systemPrompt, string $userPrompt): array
    {
        try {
            $response = Http::connectTimeout(30)
                ->timeout(300)
                ->withToken($this->apiKey)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 8000,
                ]);
        } catch (ConnectionException $e) {
            throw new AiProviderUnavailable('OpenRouter could not be reached: ' . $e->getMessage());
        }

        if ($response->failed()) {
            throw new AiProviderUnavailable('OpenRouter request failed: ' . ($response->json('error.message') ?? "HTTP {$response->status()}"));
        }

        $text = (string) $response->json('choices.0.message.content');
        $start = strpos($text, '{');
        $end = strrpos($text, '}');
        $result = $start !== false && $end !== false ? json_decode(substr($text, $start, $end - $start + 1), true) : null;

        if (!is_array($result)) {
            throw new Exception('OpenRouter did not return valid JSON');
        }

        return $result;
    }
}
