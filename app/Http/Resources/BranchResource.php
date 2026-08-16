<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'image'            => asset($this->image),
            'sub_image'        => asset($this->sub_image),
            'domain'           => $this->domain,
            'is_default'       => $this->is_default,
        ];
    }
}
