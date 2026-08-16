<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogTagResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'        => $this->id,
            'tag'       => $this->name,
            'serial_no' => $this->serial_no,
            'slug'      => $this->slug,
        ];
    }
}
