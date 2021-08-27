<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function words()
    {
        return $this->belongsToMany(Word::class);
    }
    public function log()
    {
        return $this->morphOne(Log::class, 'logable');
    }
}
