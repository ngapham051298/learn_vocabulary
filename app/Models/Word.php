<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Word extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = ['pivot', 'created_at', 'updated_at', 'deleted_at'];
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
    public static function getWords($request)
    {
        $words = Word::with('answers')
            ->join('category_word as cw', 'words.id', 'cw.word_id')
            ->join('categories as c', 'c.id', 'cw.category_id')
            ->where('c.id', $request->category_id)
            ->select('words.id', 'words.name', 'words.audio')
            ->get();
        return $words;
    }
    public static function showWord($id)
    {
        $word = Word::where('id', $id)
            ->with([
                'categories' => function ($q) {
                    $q->select('categories.id', 'categories.name', 'categories.image');
                },
                'answers'
            ])
            ->first();
        return $word;
    }
    public static function updateWord($id, $request)
    {
        $word = Word::findOrFail($id);
        $word->name = $request->name;
        if ($request->hasFile('audio')) {
            $audio   = $request->file('audio');
            $audioName = time() . ' ' . $audio->getClientOriginalName();
            $request->audio->move(public_path('Uploads/audio'), $audioName);
            $word->audio = $audioName;
        }
        $word->save();
        $word->categories()->sync($request->category_ids);
        foreach (json_decode($request->answers) as $item) {
            Answer::find($item->id)->update([
                'title' => $item->title,
                'status' => $item->status
            ]);
        }
    }
    public static function deleteWord($id)
    {
        $word = Word::findOrFail($id);
        $word->categories()->detach();
        $word->answers()->delete();
        $word->delete();
    }
}
