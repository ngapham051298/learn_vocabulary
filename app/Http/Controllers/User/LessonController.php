<?php

namespace App\Http\Controllers\User;

use App\Common\StatusCode;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LessonFormRequest;

class LessonController extends Controller
{
    public function store(LessonFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $lesson = Lesson::createLesson($request);
            DB::commit();
            return $this->successResponse($lesson, StatusCode::CREATED);
        } catch (Exception $e) {
            DB::rollback();
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
    public function show($id)
    {
        try {
            $lesson = Lesson::showLesson($id);
            return $this->successResponse($lesson, StatusCode::OK);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
}
