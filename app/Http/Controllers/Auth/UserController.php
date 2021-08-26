<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\StatusCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return $this->successResponse($user, StatusCode::OK);
    }
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $user->update($request->all());
            $user->save();
            return $this->successResponse(null, StatusCode::CREATED);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
}
