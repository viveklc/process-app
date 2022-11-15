<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'chapter' => $this->chapter->name ?? '',
            'page_type' => config('lms-config.page.page_type.'.$this->page_type) ?? '',
            'page_content' => $this->page_content ?? '',
            'page_content_url' => $this->page_content_url ?? '',
            'page_sequence' => $this->page_sequence ?? '',
            'is_first' => $this->is_first ?? '',
            'is_last' => $this->is_last ?? '',
            'is_composite' => $this->is_composite ?? '',
            'chapter_book_name' => $this->chapter->book->name ?? '',
            'is_conditional' => $this->is_conditional ?? '',
            'tags' => $this->tags ?? '',
            'status' => $this->status ?? '',
        ];
    }
}
