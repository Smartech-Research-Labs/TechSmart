<?php

namespace App\Services;

use App\Contracts\AiTextGenerator;
use App\Exceptions\AiProviderUnavailable;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Google Gemini API client, used on the free tier. Google retires models and
 * changes free limits often, so available models are looked up from the API.
 */
class GeminiService implements AiTextGenerator
{
    protected const BASE_URL = 'https://generativelanguage.googleapis.com/v1beta';

    protected string $apiKey;
    protected ?array $models = null;

    public function __construct()
    {
        $key = config('services.gemini.key') ?: Setting::get('gemini_api_key');

        if (!$key) {
            throw new AiProviderUnavailable('Gemini API key not configured');
        }

        $this->apiKey = $key;
    }

    public function chatJson(string $systemPrompt, string $userPrompt): array
    {
        $errors = [];

        foreach ($this->models() as $model) {
            try {
                $response = $this->request()->post(self::BASE_URL . "/models/{$model}:generateContent", [
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
            } catch (ConnectionException $e) {
                throw new AiProviderUnavailable('Gemini could not be reached: ' . $e->getMessage());
            }

            if ($response->status() === 401 || $response->status() === 403) {
                throw new AiProviderUnavailable('Gemini rejected the API key');
            }

            if ($response->failed()) {
                $error = $response->json('error.message') ?? "HTTP {$response->status()}";
                Log::warning('Gemini model request failed', ['model' => $model, 'status' => $response->status(), 'error' => $error]);
                $errors[] = "{$model}: {$error}";
                continue;
            }

            $text = $response->json('candidates.0.content.parts.0.text');

            if (!$text) {
                $finishReason = $response->json('candidates.0.finishReason');
                throw new Exception('Gemini returned no content' . ($finishReason ? " ({$finishReason})" : ''));
            }

            $result = json_decode($text, true);

            if (!is_array($result)) {
                throw new Exception('Gemini did not return valid JSON');
            }

            return $result;
        }

        throw new AiProviderUnavailable('No Gemini model is available. ' . implode(' | ', array_slice($errors, -2)));
    }

    protected function request(): PendingRequest
    {
        return Http::connectTimeout(30)
            ->timeout(300)
            ->withHeaders(['x-goog-api-key' => $this->apiKey]);
    }

    /** The saved model first, then current Flash models, newest first, then Flash-Lite. */
    protected function models(): array
    {
        if ($this->models !== null) {
            return $this->models;
        }

        try {
            $response = $this->request()->get(self::BASE_URL . '/models', ['pageSize' => 1000]);
        } catch (ConnectionException $e) {
            throw new AiProviderUnavailable('Gemini could not be reached: ' . $e->getMessage());
        }

        if ($response->failed()) {
            throw new AiProviderUnavailable('Gemini rejected the request: ' . ($response->json('error.message') ?? "HTTP {$response->status()}"));
        }

        $available = collect($response->json('models', []))
            ->filter(fn ($model) => in_array('generateContent', $model['supportedGenerationMethods'] ?? [], true))
            ->map(fn ($model) => str_replace('models/', '', (string) ($model['name'] ?? '')))
            ->filter(fn ($name) => preg_match('/^gemini-\d+(\.\d+)?-flash(-lite)?$/', $name))
            ->sort(function (string $a, string $b) {
                $liteOrder = str_ends_with($a, '-lite') <=> str_ends_with($b, '-lite');

                return $liteOrder ?: version_compare($this->modelVersion($b), $this->modelVersion($a));
            })
            ->values();

        $saved = Setting::get('gemini_model');
        $models = $available->contains($saved) ? collect([$saved])->merge($available)->unique() : $available;

        if ($models->isEmpty()) {
            throw new AiProviderUnavailable('Gemini returned no usable Flash model');
        }

        // Keep Flash-Lite in the list: it often has room when Flash is busy
        [$lite, $flash] = $models->partition(fn ($model) => str_ends_with($model, '-lite'));

        return $this->models = $flash->take(3)->merge($lite->take(2))->values()->all();
    }

    protected function modelVersion(string $model): string
    {
        preg_match('/^gemini-(\d+(?:\.\d+)?)/', $model, $match);

        return $match[1] ?? '0';
    }
}
