<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Services\SentimentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    public function __construct(private readonly SentimentService $sentimentService)
    {
    }

    // GET /api/reviews
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Review::class);

        return response()->json(
            Review::with('user:id,name,email,role')->latest()->get()
        );
    }

    // POST /api/reviews
    public function store(StoreReviewRequest $request): JsonResponse
    {
        $this->authorize('create', Review::class);

        $analysis = $this->sentimentService->analyze($request->validated('content'));

        $review = Review::create([
            'content' => $request->validated('content'),
            'user_id' => (int) $request->user()->id,
            'sentiment' => $analysis['sentiment'],
            'score' => $analysis['score'],
            'topics' => $analysis['topics'],
        ]);

        return response()->json($review->load('user:id,name,email,role'), 201);
    }

    // GET /api/reviews/{review}
    public function show(Review $review): JsonResponse
    {
        $this->authorize('view', $review);

        return response()->json($review->load('user:id,name,email,role'));
    }

    // PUT/PATCH /api/reviews/{review}
    public function update(Request $request, Review $review): JsonResponse
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'content' => 'required|string|min:3',
        ]);

        $analysis = $this->sentimentService->analyze($validated['content']);

        $review->update([
            'content' => $validated['content'],
            'sentiment' => $analysis['sentiment'],
            'score' => $analysis['score'],
            'topics' => $analysis['topics'],
        ]);

        return response()->json($review->fresh()->load('user:id,name,email,role'));
    }

    // DELETE /api/reviews/{review}
    public function destroy(Review $review): Response
    {
        $this->authorize('delete', $review);
        $review->delete();

        return response()->noContent();
    }

    // POST /api/analyze
    public function analyze(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|min:3',
        ]);

        return response()->json(
            $this->sentimentService->analyze($validated['text'])
        );
    }

    // GET /api/dashboard
    public function dashboard(): JsonResponse
    {
        $total = (int) Review::count();

        $positiveCount = (int) Review::where('sentiment', 'positive')->count();
        $negativeCount = (int) Review::where('sentiment', 'negative')->count();

        $positivePercent = $total > 0 ? round(($positiveCount / $total) * 100, 2) : 0;
        $negativePercent = $total > 0 ? round(($negativeCount / $total) * 100, 2) : 0;

        $topicCount = [];
        Review::query()
            ->whereNotNull('topics')
            ->pluck('topics')
            ->each(function ($topics) use (&$topicCount): void {
                if (! is_array($topics)) {
                    return;
                }
                foreach ($topics as $topic) {
                    if (! is_string($topic) || $topic === '') {
                        continue;
                    }
                    $topicCount[$topic] = ($topicCount[$topic] ?? 0) + 1;
                }
            });

        arsort($topicCount);
        $topTopics = collect(array_slice($topicCount, 0, 3, true))
            ->map(fn ($count, $topic) => ['topic' => $topic, 'count' => $count])
            ->values();

        $averageScore = round((float) Review::avg('score'), 2);

        $recentReviews = Review::with('user:id,name,email,role')
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'positive_percent' => $positivePercent,
            'negative_percent' => $negativePercent,
            'top_topics' => $topTopics,
            'average_score' => $averageScore,
            'recent_reviews' => $recentReviews,
        ]);
    }
}
