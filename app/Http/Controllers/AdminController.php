<?php

namespace App\Http\Controllers;

use App\Models\Review;

class AdminController extends Controller
{
    public function index()
    {
        $totalReviews = Review::count();

        $todayReviews = Review::whereDate(
            'created_at',
            today()
        )->count();

        return view('admin', compact(
            'totalReviews',
            'todayReviews',
        ));
    }
}
