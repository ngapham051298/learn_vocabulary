<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = ['id'];
    public function lesson_results()
    {
        return $this->hasMany(LessonResult::class);
    }
    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
