<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public static function createUser($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $image = $request->file('image');
        $nameImage = time() . ' ' . $image->getClientOriginalName();
        $request->image->move(public_path('Uploads/image/user'), $nameImage);
        $user->image = $nameImage;
        $user->save();
    }
    public static function getUsers()
    {
        $users = User::all();
        return $users;
    }
    public static function showUser($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }
}
