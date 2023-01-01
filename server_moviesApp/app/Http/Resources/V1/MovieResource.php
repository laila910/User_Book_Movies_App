<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'type'=>$this->type,
            'image'=>$this->image,
            'ticketPrice'=>$this->ticketPrice,
            'createdTime'=>$this->pretty_created,
            'MovieShowsDetails'=>$this->extra->arr
        ];
    }
}
