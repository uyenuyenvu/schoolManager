<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedules extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject_id','teacher_id','class_id','day_index','lesson_index'
    ];
}
