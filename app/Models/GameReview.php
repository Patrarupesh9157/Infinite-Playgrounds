<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameReview extends Model
{
    use HasFactory;

    // Table name (optional if the table follows Laravel's naming convention)
    protected $table = 'game_reviews';

    // Mass assignable attributes
    protected $fillable = [
        'game_id',
        'user_id',
        'comment',
        'rating',
    ];

    /**
     * Relationship with the Game model.
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    /**
     * Relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
