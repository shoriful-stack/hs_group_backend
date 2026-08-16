<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'         => $this->id,
            'branch'     => optional( $this->branch )->name,
            'language'   => optional( $this->language )->name,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'serial_no'  => $this->serial_no,
            'status'     => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
