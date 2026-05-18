<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,            
            'rating'     => $this->rating,
            'comment'    => $this->comment,
            'created_at' => $this->created_at,
            'user'       => new UserPublicResource($this->whenLoaded('user')),            
            'title'       => new TitleResource($this->whenLoaded('title'))
        ];
    }
}
