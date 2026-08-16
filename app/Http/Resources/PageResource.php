<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'              => $this->id,
            'branch'          => optional( $this->branch )->name,
            'title'           => $this->title,
            'slug'            => $this->slug,
            'content'         => $this->content,
            'main_image'      => asset($this->main_image),
            'sub_image'       => asset($this->sub_image),
            'seo_title'       => $this->seo_title,
            'seo_description' => $this->seo_description,
            'seo_keywords'    => $this->seo_keywords,
            'serial_no'       => $this->serial_no,
        ];
    }
}
