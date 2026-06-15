<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeSessionPackage extends Model
{
    protected $fillable = ['name', 'minutes', 'price', 'status'];
}
