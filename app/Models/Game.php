<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'html_code',
        'css_code',
        'js_code',
        'images',
    ];

    protected $casts = [
        'images' => 'array', // Cast images field to an array
    ];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y H:i'); // Example format: January 1, 2024
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y, g:i A'); // Example format: January 1, 2024, 10:30 AM
    }
    public function likes()
    {
        return $this->hasMany(GameLike::class);
    }

    public function reviews()
    {
        return $this->hasMany(GameReview::class);
    }
}
