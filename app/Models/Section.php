<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'sort_order',
        'total_items',
        'total_duration'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'total_items' => 'integer',
        'total_duration' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'duration_formatted',
        'lessons_count',
        'published_lessons_count'
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

    public function publishedLessons()
    {
        return $this->lessons()->where('status', 'published');
    }

    // Accessors
    public function getDurationFormattedAttribute()
    {
        if (!$this->total_duration) {
            return '0 min';
        }

        $hours = floor($this->total_duration / 3600);
        $minutes = floor(($this->total_duration % 3600) / 60);

        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        return $minutes . ' min';
    }

    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }

    public function getPublishedLessonsCountAttribute()
    {
        return $this->publishedLessons()->count();
    }

    // Methods
    public function updateStats()
    {
        $this->total_items = $this->lessons()->count();
        $this->total_duration = $this->lessons()->sum('video_duration');
        $this->save();

        // Update course stats
        if ($this->course) {
            $this->course->total_lessons = $this->course->sections->sum('total_items');
            $this->course->total_duration = $this->course->sections->sum('total_duration');
            $this->course->save();
        }
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($section) {
            // Delete all lessons in this section
            foreach ($section->lessons as $lesson) {
                $lesson->delete();
            }
        });
    }
}