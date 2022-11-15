<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
            'course' => $this->course->name ?? '',
            'level' => $this->level->name ?? '',
            'subject' => $this->subject->name ?? '',
            'book' => $this->book->name ?? '',
            'sequence' => $this->sequence ?? '',
            'tags' => $this->tags ?? '',
            'status' => $this->status ?? '',
            'image' => $this->chapterMedia(),
        ];
    }
}
