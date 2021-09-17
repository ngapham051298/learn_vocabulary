<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\StatusCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserFormRequest;

class UserController extends Controller
{
    public function index()
    {
        $user = [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'image' => request()->getSchemeAndHttpHost() . Auth::user()->image,
            'gender' => Auth::user()->gender,
            'phone' => Auth::user()->phone,
        ];
        return $this->successResponse($user, StatusCode::OK);
    }
    public function update(UpdateUserFormRequest $request)
    {
        try {
            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $nameImage = time() . '_' . $image->getClientOriginalName();
                $request->image->move(public_path('uploads/image/user'), $nameImage);
                $path = "/uploads/image/user/$nameImage";
                $user->image = $path;
            }
            $user->save();
            return $this->successResponse(null, StatusCode::CREATED);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
}
