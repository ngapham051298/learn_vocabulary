<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $guarded = ['id'];
    public function answers(){
        return $this->hasMany(Answer::class);
    }
    public function lesson_results(){
        return $this->hasMany(LessonResult::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
