<?php

namespace App\Http\Controllers\User;

use App\Common\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Log;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResources;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = new UserResources(User::getActivitives());
            return $this->successResponse($user, StatusCode::OK);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
}
