<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Word extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function lesson_results()
    {
        return $this->hasMany(LessonResult::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public static function createWord($request)
    {
        $word = new Word();
        $audio   = $request->file('audio');
        $audioName = time() . ' ' . $audio->getClientOriginalName();
        $request->audio->move(public_path('Uploads/audio'), $audioName);
        $word->name = $request->name;
        $word->audio = $audioName;
        $word->save();
        $word->categories()->attach($request->category_ids);
        $answers = [];
        foreach (json_decode($request->answers) as $item) {
            $answer = [
                'title' => $item->title,
                'status' => $item->status,
                'word_id' => $word->id
            ];
            array_push($answers, $answer);
        }
        Answer::insert($answers);
    }
}
