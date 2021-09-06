<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['pivot', 'created_at', 'updated_at', 'deleted_at'];
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
    public static function getCategories()
    {
        $categories = Category::with('words')->get();
        return $categories;
    }
    public static function createCategory($request)
    {
        $category = new Category();
        $image   = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $request->image->move(public_path('Uploads/image'), $imageName);
        $category->name = $request->name;
        $category->image = $imageName;
        $category->save();
    }
    public static function updateCategory($request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        if ($request->hasFile('image')) {
            $image   = $request->file('image');
            $imageName = time() . ' ' . $image->getClientOriginalName();
            $request->image->move(public_path('Uploads/image'), $imageName);
            $category->image = $imageName;
        }
        $category->save();
    }
}
