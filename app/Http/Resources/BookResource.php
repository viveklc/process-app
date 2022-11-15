<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'name' => $this->name,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'front_cover_image_url' => $this->getMedia('BookFrontCover')[0]->original_url ?? '',
            'back_cover_image_url' => $this->getMedia('BookBackCover')[0]->original_url ?? '',
            'course_name' => $this->course->name ?? '',
            'level_name' => $this->level->name ?? '',
            'subject_name' => $this->subject->name ?? '',
            'tags' => $this->tags
        ];
    }
}
