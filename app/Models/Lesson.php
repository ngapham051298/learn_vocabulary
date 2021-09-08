<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Word;
use App\Models\LessonResult;
use Illuminate\Support\Facades\Auth;

class Lesson extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    public function lesson_results()
    {
        return $this->hasMany(LessonResult::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public static function createLesson($request)
    {
        $lesson = new Lesson();
        $lesson->user_id = Auth::user()->id;
        $lesson->category_id = $request->category_id;
        $lesson->save();
        $words = Word::join('category_word as cw', 'words.id', 'cw.word_id')
            ->where('cw.category_id', $request->category_id)
            ->whereNotIn('words.id', ['lesson_results.word_id'])
            ->inRandomOrder()
            ->limit(20)
            ->select('words.*')
            ->get();
        $lesson_results = [];
        foreach ($words as $item) {
            $lesson_result = [
                'word_id' => $item['id'],
                'lesson_id' => $lesson->id
            ];
            array_push($lesson_results, $lesson_result);
        }
        LessonResult::insert($lesson_results);
        $final_lesson = Lesson::with(['lesson_results', 'lesson_results.word', 'lesson_results.word.answers'])
            ->where('id', $lesson->id)
            ->get();
        return $final_lesson;
    }
}
