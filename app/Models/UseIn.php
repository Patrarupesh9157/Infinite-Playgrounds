<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseIn extends Model
{
    use HasFactory;
    protected $table = 'use_ins';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = [
        'name'
    ];
}
