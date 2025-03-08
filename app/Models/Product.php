<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $incrementing = true;

    // Define the fillable fields
    protected $fillable = [
        'name',
        'area_id',
        'concept_id',
        'fabric_id',
        'panna_id',
        'technical_concept_id',
        'use_in_id',
        'yarn_id',
        'price',
        'images',
        'design_name',
        'rate',
        'height',
        'date',
        'stitches'
    ];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y H:i'); // Example format: January 1, 2024
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F j, Y, g:i A'); // Example format: January 1, 2024, 10:30 AM
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function concept()
    {
        return $this->belongsTo(Concept::class);
    }

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function panna()
    {
        return $this->belongsTo(Panna::class);
    }

    public function technicalConcept()
    {
        return $this->belongsTo(TechnicallyConcept::class, 'technical_concept_id');
    }

    public function useIn()
    {
        return $this->belongsTo(UseIn::class);
    }

    public function yarn()
    {
        return $this->belongsTo(Yarn::class);
    }
}
