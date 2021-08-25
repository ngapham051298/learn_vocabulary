<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse{

    protected function successResponse($data,$code)
	{
		return response()->json([
			'status'=> true, 
			'message' => 'success', 
			'data' => $data,
		],$code);
	}

	protected function errorResponse($message = null,$code)
	{
		return response()->json([
			'status'=> false,
			'message' => $message,
		],$code);
	}
}
