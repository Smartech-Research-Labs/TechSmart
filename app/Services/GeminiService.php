<?php

namespace App\Services;

use App\Contracts\AiTextGenerator;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Google Gemini API client (free-tier eligible — no billing required for
 * the flash models at normal low-volume usage like this blog automation).
 * Uses the raw REST API directly via Laravel's HTTP client since there's
 * no official first-party Gemini PHP SDK, unlike OpenAI.
 */
class GeminiService implements AiTextGenerator
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $key = config('services.gemini.key') ?: Setting::get('gemini_api_key');

        if (!$key) {
            throw new Exception('Gemini API key not configured');
        }

        $this->apiKey = $key;
        $this->model = Setting::get('gemini_model', 'gemini-2.5-flash');
    }

    public function chatJson(string $systemPrompt, string $userPrompt): array
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";

        $response = Http::timeout(120)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url . '?key=' . $this->apiKey, [
                'system_instruction' => [
                    'parts' => [['text' => $systemPrompt]],
                ],
                'contents' => [
                    ['role' => 'user', 'parts' => [['text' => $userPrompt]]],
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 16000,
                    'responseMimeType' => 'application/json',
                ],
            ]);

        if ($response->failed()) {
            $error = $response->json('error.message') ?? $response->body();
            Log::error('Gemini API request failed', ['error' => $error, 'status' => $response->status()]);
            throw new Exception('Gemini request failed: ' . $error);
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (!$text) {
            $finishReason = $response->json('candidates.0.finishReason');
            throw new Exception('Gemini returned no content' . ($finishReason ? " (finishReason: {$finishReason})" : ''));
        }

        $result = json_decode($text, true);

        if (!is_array($result)) {
            throw new Exception('Gemini did not return valid JSON');
        }

        return $result;
    }
}
