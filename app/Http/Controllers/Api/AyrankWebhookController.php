<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AyrankPublisher;
use App\Services\SiteSeo;
use Illuminate\Http\Request;
use InvalidArgumentException;

/** Receives signed blog posts from AYRank. */
class AyrankWebhookController extends Controller
{
    protected const MAX_SIGNATURE_AGE_SECONDS = 300;

    public function __invoke(Request $request, AyrankPublisher $publisher)
    {
        $secret = (string) config('services.ayrank.webhook_secret');

        if ($secret === '') {
            return response()->json(['message' => 'Webhook is not configured'], 503);
        }

        $body = $request->getContent();

        if (!$this->hasValidSignature((string) $request->header('ayrank-signature'), $body, $secret)) {
            return response('Invalid signature', 401);
        }

        $payload = json_decode($body, true);

        if (!is_array($payload)) {
            return response()->json(['message' => 'Invalid JSON'], 400);
        }

        $event = $payload['event'] ?? null;
        $article = is_array($payload['article'] ?? null) ? $payload['article'] : [];
        $publication = is_array($payload['publication'] ?? null) ? $payload['publication'] : [];

        try {
            return match ($event) {
                'publish', 'update' => $this->saved($publisher->save($article, $publication, $event === 'update')),
                'unpublish' => response()->json(['ok' => true, 'id' => $publisher->unpublish($article)]),
                default => response()->json(['ok' => true]),
            };
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    protected function saved($blog)
    {
        return response()->json([
            'id' => $blog->ayrank_id,
            'url' => SiteSeo::baseUrl() . "/blog/{$blog->slug}",
        ]);
    }

    protected function hasValidSignature(string $header, string $body, string $secret): bool
    {
        $parts = [];

        foreach (explode(',', $header) as $part) {
            [$name, $value] = array_pad(explode('=', trim($part), 2), 2, '');
            $parts[$name] = $value;
        }

        $timestamp = $parts['t'] ?? '';
        $signature = $parts['v1'] ?? '';

        if (!ctype_digit($timestamp) || $signature === '' || abs(time() - (int) $timestamp) >= self::MAX_SIGNATURE_AGE_SECONDS) {
            return false;
        }

        return hash_equals(hash_hmac('sha256', "{$timestamp}.{$body}", $secret), $signature);
    }
}
