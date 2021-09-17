<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Answer;

class LessonResult extends JsonResource
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
            'status' => $this->status,
            'word_name' => $this->word->name,
            'word_audio' => $request->getSchemeAndHttpHost() . $this->word->audio,
            'answer' => new Answer($this->answer),
        ];
    }
}
