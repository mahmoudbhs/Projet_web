<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    // 🔹 Voir toutes les reviews
    public function viewAny(User $user)
    {
        return true;
    }

    // 🔹 Voir une review
    public function view(User $user, Review $review)
    {
        return true;
    }

    // 🔹 Créer une review
    public function create(User $user)
    {
        return true;
    }

    // 🔹 Modifier une review
    public function update(User $user, Review $review)
    {
        // admin OU propriétaire
        return $user->role === 'admin' || $user->id === $review->user_id;
    }

    // 🔹 Supprimer une review
    public function delete(User $user, Review $review)
    {
        return $user->role === 'admin' || $user->id === $review->user_id;
    }

    // 🔹 Restaurer (optionnel)
    public function restore(User $user, Review $review)
    {
        return false;
    }

    // 🔹 Supprimer définitivement (optionnel)
    public function forceDelete(User $user, Review $review)
    {
        return $user->role === 'admin';
    }
}