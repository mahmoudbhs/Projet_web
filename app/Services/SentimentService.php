<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SentimentService
{
    /**
     * @return array{sentiment:string,score:int,topics:array<int,string>}
     */
    public function analyze(string $content): array
    {
        try {
            $apiKey = config('services.groq.api_key');
            $model = config('services.groq.model', 'llama-3.1-8b-instant');

            if (! $apiKey) {
                return $this->fallback($content);
            }

            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => $model,
                    'temperature' => 0,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Return only valid JSON with keys sentiment, score, topics. sentiment: positive|neutral|negative. score: integer from 0 to 100. topics: array of short snake_case strings.',
                        ],
                        [
                            'role' => 'user',
                            'content' => "Analyze this customer review:\n".$content,
                        ],
                    ],
                    'response_format' => [
                        'type' => 'json_object',
                    ],
                ]);

            if (! $response->successful()) {
                return $this->fallback($content);
            }

            $raw = (string) data_get($response->json(), 'choices.0.message.content', '');
            $payload = json_decode($this->extractJsonPayload($raw), true);

            if (! is_array($payload)) {
                return $this->fallback($content);
            }

            return $this->normalize($payload);
        } catch (\Throwable $e) {
            return $this->fallback($content);
        }
    }

    private function extractJsonPayload(string $content): string
    {
        $trimmed = trim($content);
        if (str_starts_with($trimmed, '```')) {
            $trimmed = preg_replace('/^```(?:json)?\s*/i', '', $trimmed) ?? $trimmed;
            $trimmed = preg_replace('/\s*```$/', '', $trimmed) ?? $trimmed;
        }

        return trim($trimmed);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array{sentiment:string,score:int,topics:array<int,string>}
     */
    private function normalize(array $payload): array
    {
        $sentiment = strtolower((string) ($payload['sentiment'] ?? 'neutral'));
        if (! in_array($sentiment, ['positive', 'neutral', 'negative'], true)) {
            $sentiment = 'neutral';
        }

        $score = (int) ($payload['score'] ?? 50);
        $score = max(0, min(100, $score));

        $topics = [];
        if (is_array($payload['topics'] ?? null)) {
            foreach ($payload['topics'] as $topic) {
                if (! is_string($topic)) {
                    continue;
                }

                $clean = strtolower(trim($topic));
                $clean = preg_replace('/[^a-z0-9_]+/', '_', $clean) ?? '';
                $clean = trim($clean, '_');

                if ($clean !== '') {
                    $topics[] = $clean;
                }
            }
        }

        return [
            'sentiment' => $sentiment,
            'score' => $score,
            'topics' => array_values(array_unique($topics)),
        ];
    }

    /**
     * Rule-based fallback when external AI is unavailable.
     *
     * @return array{sentiment:string,score:int,topics:array<int,string>}
     */
    private function fallback(string $content): array
    {
        $text = strtolower($content);

        $positiveWords = ['excellent', 'super', 'rapide', 'parfait', 'bon', 'bonne', 'satisfait', 'top'];
        $negativeWords = ['mauvais', 'nul', 'retard', 'lent', 'horrible', 'decu', 'cher', 'probleme'];

        $positive = 0;
        foreach ($positiveWords as $word) {
            $positive += substr_count($text, $word);
        }

        $negative = 0;
        foreach ($negativeWords as $word) {
            $negative += substr_count($text, $word);
        }

        $sentiment = 'neutral';
        if ($positive > $negative) {
            $sentiment = 'positive';
        } elseif ($negative > $positive) {
            $sentiment = 'negative';
        }

        $score = max(0, min(100, 50 + (($positive - $negative) * 12)));

        $topicKeywords = [
            'delivery' => ['livraison', 'retard', 'colis', 'expedition'],
            'price' => ['prix', 'cher', 'promo', 'tarif', 'cout'],
            'quality' => ['qualite', 'casse', 'solide', 'materiau'],
            'support' => ['support', 'service', 'sav', 'aide'],
            'speed' => ['rapide', 'lent', 'vitesse', 'delai'],
        ];

        $topics = [];
        foreach ($topicKeywords as $topic => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    $topics[] = $topic;
                    break;
                }
            }
        }

        return [
            'sentiment' => $sentiment,
            'score' => (int) $score,
            'topics' => $topics,
        ];
    }
}
