<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChooseUsResource extends JsonResource {
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
            'image'      => asset($this->image),
            'content'    => $this->content,
            'features'   => json_decode($this->features, true),
        ];
    }
}
