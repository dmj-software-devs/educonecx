<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    // Relationships
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_tags');
    }

    // Scopes
    public function scopePopular($query)
    {
        return $query->withCount('courses')->orderBy('courses_count', 'desc');
    }
}