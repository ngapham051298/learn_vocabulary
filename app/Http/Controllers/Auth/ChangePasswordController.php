<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Common\StatusCode;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordFormRequest;

class ChangePasswordController extends Controller
{
    public function changePassword(PasswordFormRequest $request)
    {
        try {
            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                return $this->errorResponse('The current password is wrong', StatusCode::BAD_REQUEST);
            }
            $user = Auth::user();
            $user->password = $request->get('new-password');
            $user->save();
            return $this->successResponse(null, StatusCode::CREATED);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
    
}
