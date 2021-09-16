<?php

namespace App\Http\Controllers\User;

use App\Common\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use App\Http\Resources\Category as CategoryResources;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = CategoryResources::collection(Category::userGetCategories());
            return $this->successResponse($categories, StatusCode::OK);
        } catch (Exception $e) {
            return $this->errorResponse($e . 'Error', StatusCode::BAD_REQUEST);
        }
    }
}
