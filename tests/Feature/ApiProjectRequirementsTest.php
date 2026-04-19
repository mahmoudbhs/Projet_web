<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\User;
use App\Services\SentimentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class ApiProjectRequirementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_analyze_endpoint_returns_expected_structure(): void
    {
        $mock = Mockery::mock(SentimentService::class);
        $mock->shouldReceive('analyze')
            ->once()
            ->with('Livraison rapide mais prix eleve')
            ->andReturn([
                'sentiment' => 'neutral',
                'score' => 62,
                'topics' => ['delivery', 'price'],
            ]);

        $this->app->instance(SentimentService::class, $mock);

        $response = $this->postJson('/api/analyze', [
            'text' => 'Livraison rapide mais prix eleve',
        ]);

        $response->assertOk()
            ->assertJson([
                'sentiment' => 'neutral',
                'score' => 62,
                'topics' => ['delivery', 'price'],
            ]);
    }

    public function test_store_review_triggers_ai_and_saves_fields(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $mock = Mockery::mock(SentimentService::class);
        $mock->shouldReceive('analyze')
            ->once()
            ->with('Service parfait et livraison rapide')
            ->andReturn([
                'sentiment' => 'positive',
                'score' => 90,
                'topics' => ['delivery', 'support'],
            ]);

        $this->app->instance(SentimentService::class, $mock);

        $response = $this->postJson('/api/reviews', [
            'content' => 'Service parfait et livraison rapide',
        ]);

        $response->assertCreated()
            ->assertJsonPath('sentiment', 'positive')
            ->assertJsonPath('score', 90)
            ->assertJsonPath('topics.0', 'delivery');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'sentiment' => 'positive',
            'score' => 90,
        ]);
    }

    public function test_dashboard_endpoint_returns_required_statistics(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Review::factory()->createMany([
            [
                'user_id' => $user->id,
                'content' => 'Super service',
                'sentiment' => 'positive',
                'score' => 95,
                'topics' => ['support', 'quality'],
            ],
            [
                'user_id' => $user->id,
                'content' => 'Livraison en retard',
                'sentiment' => 'negative',
                'score' => 30,
                'topics' => ['delivery'],
            ],
        ]);

        $response = $this->getJson('/api/dashboard');

        $response->assertOk()
            ->assertJsonStructure([
                'positive_percent',
                'negative_percent',
                'top_topics',
                'average_score',
                'recent_reviews',
            ]);
    }
}
