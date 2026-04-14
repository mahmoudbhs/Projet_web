<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return Review::latest()->get();
    }

    public function store(Request $request)
    {
        $review = Review::create([
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        //Analyse IA
        $sentiment = $this->analyze($review->content);
        $review->update(['sentiment' => $sentiment]);

        return $review;
    }

    private function analyze($text)
    {
        if (str_contains(strtolower($text), 'bien')) return 'positif';
        if (str_contains(strtolower($text), 'mauvais')) return 'negatif';
        return 'neutre';

        //VERSION API IA
        /*
        $response = Http::withHeaders([
            'Authorization' => 'Bearer YOUR_API_KEY',
        ])->post('https://api.openai.com/v1/...', [
            'input' => $text
        ]);

        return $response['sentiment'];
        */
    }
}
