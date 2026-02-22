<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'title', 'description', 'sort_order', 
        'total_items', 'total_duration'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'total_items' => 'integer',
        'total_duration' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    // Accessors
    public function getPublishedLessonsAttribute()
    {
        return $this->lessons()->where('status', 'published')->get();
    }

    public function getDurationFormattedAttribute()
    {
        $hours = floor($this->total_duration / 60);
        $minutes = $this->total_duration % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . ' min';
    }
}