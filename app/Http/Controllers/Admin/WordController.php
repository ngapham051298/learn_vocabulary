<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Word;
use App\Common\StatusCode;
use Exception;
use App\Http\Requests\WordFormRequest;
use App\Http\Requests\SearchWordFormRequest;
use Illuminate\Support\Facades\DB;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchWordFormRequest $request)
    {
        try {
            $words = Word::getWords($request);
            return $this->successResponse($words, StatusCode::OK);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WordFormRequest $request)
    {
        try {
            DB::beginTransaction();
            Word::createWord($request);
            DB::commit();
            return $this->successResponse(null, StatusCode::CREATED);
        } catch (Exception $e) {
            DB::rollback();
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $word = Word::showWord($id);
            return $this->successResponse($word, StatusCode::OK);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WordFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $word = Word::updateWord($id, $request);
            DB::commit();
            return $this->successResponse(null, StatusCode::CREATED);
        } catch (Exception $e) {
            DB::rollback();
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
