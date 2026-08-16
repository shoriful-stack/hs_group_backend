<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSectionResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'       => $this->id,
            'position' => $this->position,
            'title'    => $this->title,
            'page'     => new PageResource( $this->page ),
        ];
    }
}
