<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;

class ReviewController extends Controller
{
    // 🔹 GET /api/reviews
    public function index()
    {
        $this->authorize('viewAny', Review::class);

        return Review::with('user')->latest()->get();
    }

    // 🔹 POST /api/reviews
    public function store(StoreReviewRequest $request)
    {
        $this->authorize('create', Review::class);

        $review = Review::create([
            'content' => $request->validated('content'),
            'user_id' => auth()->id(),
        ]);

        // 🔥 Analyse simple
        $sentiment = $this->analyze($review->content);
        $review->update(['sentiment' => $sentiment]);

        return response()->json($review->load('user'), 201);
    }

    // 🔹 GET /api/reviews/{review}
    public function show(Review $review)
    {
        $this->authorize('view', $review);

        return $review->load('user');
    }

    // 🔹 PUT /api/reviews/{review}
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'content' => 'required|string',
        ]);

        $review->update([
            'content' => $request->content,
        ]);

        return response()->json($review->load('user'));
    }

    // 🔹 DELETE /api/reviews/{review}
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return response()->json([
            'message' => 'Review supprimée'
        ]);
    }

    // 🔹 Analyse simple (IA basique)
    private function analyze($text)
    {
        $text = strtolower($text);

        if (str_contains($text, 'bien')) return 'positif';
        if (str_contains($text, 'mauvais')) return 'negatif';

        return 'neutre';
    }
}