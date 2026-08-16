<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVideoResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'         => $this->id,
            'product'    => optional( $this->product )->name,
            'title'      => $this->title,
            'image'      => asset( $this->image ),
            'content'    => $this->content,
            'video_link' => $this->video_link,
        ];
    }
}
