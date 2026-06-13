<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnglishPracticeCourseModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'english_practice_course_id',
        'title',
        'description',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(EnglishPracticeCourse::class, 'english_practice_course_id');
    }

    public function lessons()
    {
        return $this->hasMany(EnglishPracticeLesson::class, 'english_practice_course_module_id')->orderBy('sort_order');
    }
}
