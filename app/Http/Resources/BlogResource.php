<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'              => $this->id,
            'category'        => optional( $this->category )->name,
            'category_slug'   => optional( $this->category )->slug,
            'title'           => $this->title,
            'slug'            => $this->slug,
            'content'         => $this->content,
            'image'           => asset( $this->image ),
            'seo_title'       => $this->seo_title,
            'seo_description' => $this->seo_description,
            'seo_keywords'    => $this->seo_keywords,
            'serial_no'       => $this->serial_no,
            'status'          => $this->status,
            'tags'            => BlogTagResource::collection( $this->whenLoaded( 'tags' ) ),
            'published_at'    => $this->published_at,
            'created_at'      => $this->created_at,
            'created_by'      => optional( $this->createdBy )->name,
            'updated_at'      => $this->updated_at,
        ];
    }
}
