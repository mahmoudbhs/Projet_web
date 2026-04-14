<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class SentimentService
{
    public function analyze(string $content): array
    {
        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [[
                    'role' => 'user',
                    'content' => "Analyse ce texte et réponds UNIQUEMENT en JSON valide, sans texte autour :
{\"sentiment\":\"positive\",\"score\":0.9,\"topics\":[\"topic1\"]}

Les valeurs possibles pour sentiment sont : positive, negative, neutral
Le score est entre 0.0 et 1.0

Texte à analyser: {$content}"
                ]],
            ]);

            return json_decode(
                $response->choices[0]->message->content, true
            ) ?? ['sentiment' => 'neutral', 'score' => 0.5, 'topics' => []];

        } catch (\Exception $e) {
            return ['sentiment' => 'neutral', 'score' => 0.5, 'topics' => []];
        }
    }
}