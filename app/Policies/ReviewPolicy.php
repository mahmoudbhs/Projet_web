<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Review $review): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'user';
    }

    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->role === 'admin';
    }

    public function restore(User $user, Review $review): bool
    {
        return false;
    }

    public function forceDelete(User $user, Review $review): bool
    {
        return $user->role === 'admin';
    }
}
