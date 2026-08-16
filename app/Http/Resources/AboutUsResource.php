<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'         => $this->id,
            'branch'     => optional( $this->branch )->name,
            'title'      => $this->title,
            'content'    => $this->content,
            'image'      => asset($this->image),
        ];
    }
}
