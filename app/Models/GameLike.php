<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLike extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'game_likes';

    // Primary key of the table
    protected $primaryKey = 'id';

    // Auto-incrementing key type
    public $incrementing = true;

    // Data type of the primary key
    protected $keyType = 'bigint';

    // Timestamps (enabled by default in Laravel)
    public $timestamps = true;

    // Mass assignable attributes
    protected $fillable = [
        'game_id',
        'user_id',
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
