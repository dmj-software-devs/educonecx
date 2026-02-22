<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'quiz_id', 'attempt_number', 'score', 'percentage',
        'passed', 'time_taken', 'started_at', 'completed_at', 'status'
    ];

    protected $casts = [
        'attempt_number' => 'integer',
        'score' => 'integer',
        'percentage' => 'decimal:2',
        'passed' => 'boolean',
        'time_taken' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'attempt_id');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePassed($query)
    {
        return $query->where('passed', true);
    }

    public function scopeFailed($query)
    {
        return $query->where('passed', false)->where('status', 'completed');
    }

    // Accessors
    public function getTimeTakenFormattedAttribute()
    {
        if (!$this->time_taken) return 'N/A';
        
        $minutes = floor($this->time_taken / 60);
        $seconds = $this->time_taken % 60;
        
        if ($minutes > 0) {
            return $minutes . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
        }
        
        return $seconds . ' seconds';
    }
}