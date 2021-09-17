<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LessonResult;
use App\Http\Resources\Category;

class Lesson extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'lesson_results' => LessonResult::collection($this->lesson_results),
        ];
    }
}
