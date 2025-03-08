<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    use HasFactory;

    // Define the table associated with the model if it does not follow Laravel's naming convention
    protected $table = 'concept'; // Use plural form if the table name is plural

    // Specify the primary key type
    protected $keyType = 'int'; // Use 'int' for auto-incrementing integers (default behavior for 'id')

    // Indicates if the IDs are auto-incrementing
    public $incrementing = true;

    // Define which attributes are mass assignable
    protected $fillable = [
        'name',
    ];

    // If you want to disable timestamps (created_at and updated_at) use the following line:
    // public $timestamps = false;
}