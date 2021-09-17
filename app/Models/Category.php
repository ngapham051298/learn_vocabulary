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
        return $this->morphMany(Log::class, 'logable');
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
        $request->image->move(public_path('uploads/image/category'), $imageName);
        $path = "/uploads/image/category/$imageName";
        $category->name = $request->name;
        $category->image = $path;
        $category->save();
    }
    public static function updateCategory($request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        if ($request->hasFile('image')) {
            $image   = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $request->image->move(public_path('uploads/image/category'), $imageName);
            $path = "/uploads/image/category/$imageName";
            $category->image = $path;
        }
        $category->save();
    }
    public static function userGetCategories()
    {
        $categories = Category::with('words:name,audio')->get();
        return $categories;
    }
}
