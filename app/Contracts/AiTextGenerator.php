<?php

namespace App\Contracts;

interface AiTextGenerator
{
    /**
     * Send a system + user prompt and return the model's response decoded
     * as a strict JSON associative array.
     *
     * @return array<string, mixed>
     */
    public function chatJson(string $systemPrompt, string $userPrompt): array;
}
