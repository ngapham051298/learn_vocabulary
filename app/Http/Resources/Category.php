<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Word;

class Category extends JsonResource
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
            'name' => $this->name,
            'image' => request()->getSchemeAndHttpHost() . $this->image,
            'words' =>   Word::collection($this->words)
        ];
    }
}
