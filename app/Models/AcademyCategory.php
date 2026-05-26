<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'level',
        'status',
        'sort_order',
    ];

    public function scenarios()
    {
        return $this->hasMany(AcademyScenario::class)->orderBy('sort_order');
    }
}
