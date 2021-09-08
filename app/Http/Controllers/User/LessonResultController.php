<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LessonResult;
use App\Common\StatusCode;
use Exception;
use App\Http\Requests\LessonResultFormRequest;

class LessonResultController extends Controller
{
    public function update(LessonResultFormRequest $request, $id)
    {
        try {
            $lesson_result = LessonResult::updateLessonResult($request, $id);
            return $this->successResponse(null, StatusCode::CREATED);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
}
