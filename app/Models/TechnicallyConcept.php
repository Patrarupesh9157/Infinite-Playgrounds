<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicallyConcept extends Model
{
    use HasFactory;
    protected $table = 'technically_concepts';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = [
        'name'
    ];
}
