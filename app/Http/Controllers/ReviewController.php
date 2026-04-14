<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // 🔹 GET /reviews
    public function index()
    {
        $this->authorize('viewAny', Review::class);

        return Review::with('user')->latest()->get();
    }

    // 🔹 POST /reviews
    public function store(StoreReviewRequest $request)
    {
        $this->authorize('create', Review::class);

        $review = Review::create([
            'content' => $request->validated('content'),
            'user_id' => auth()->id(),
        ]);

        return response()->json($review->load('user'), 201);
    }

    // 🔹 GET /reviews/{id}
    public function show(Review $review)
    {
        $this->authorize('view', $review);

        return $review->load('user');
    }

    // 🔹 PUT /reviews/{id}
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

    // 🔹 DELETE /reviews/{id}
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
