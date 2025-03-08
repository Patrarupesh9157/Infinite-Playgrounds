<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panna extends Model
{
    use HasFactory;
    protected $table = 'pannas';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = [
        'name'
    ];
}
