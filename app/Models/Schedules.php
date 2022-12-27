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
    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'id', 'teacher_id');
    }
    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'class_id');
    }
}
