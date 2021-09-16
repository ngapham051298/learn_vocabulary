<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Log;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'image' => $request->getSchemeAndHttpHost() . $this->image,
            'logs' => Log::collection($this->logs),
        ];
    }
}
