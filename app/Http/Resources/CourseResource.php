<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name ?? '',
            'short_description' => $this->short_description ?? '',
            'long_description' => $this->long_description ?? '',
            'course' => $this->tag_data ?? '',
            'status' => $this->status ?? '',
            'image' => $this->courseMedia(),
        ];
    }
}
