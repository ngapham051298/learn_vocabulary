<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Common\StatusCode;
use App\Models\Word;
use App\Http\Requests\SearchWordFormRequest;
use App\Http\Resources\Word as WordResources;

class WordController extends Controller
{
    public function index(SearchWordFormRequest $request)
    {
        try {
            $words = Word::userGetWords($request);
            return $this->successResponse($words, StatusCode::OK);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
}
