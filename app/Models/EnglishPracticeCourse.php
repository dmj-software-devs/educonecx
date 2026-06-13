<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class EnglishPracticeCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'level',
        'status',
        'sort_order',
        'created_by',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function modules()
    {
        return $this->hasMany(EnglishPracticeCourseModule::class)->orderBy('sort_order');
    }

    public function lessons()
    {
        return $this->hasMany(EnglishPracticeLesson::class)->orderBy('sort_order');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : asset('images/course-placeholder.jpg');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
