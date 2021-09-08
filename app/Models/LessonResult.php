<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;

class LessonResult extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
    public function word()
    {
        return $this->belongsTo(Word::class);
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    public static function updateLessonResult($request, $id)
    {
        $lesson_result = LessonResult::findOrFail($id);
        $lesson_result->answer_id = $request->answer_id;
        $answer = Answer::find($request->answer_id);
        $lesson_result->status =  $answer->status;
        $lesson_result->save();
    }
}
