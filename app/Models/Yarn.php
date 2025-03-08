<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yarn extends Model
{
    use HasFactory;
    protected $table = 'yarns';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = [
        'name'
    ];
}
