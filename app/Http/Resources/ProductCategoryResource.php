<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'branch'     => optional($this->branch)->name,
            'language'   => optional($this->language)->name,
            'type'       => $this->type,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'serial'     => $this->serial,
            'parent_id' => $this->parent_id,
            'children'  => ProductCategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
