<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSettingResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'             => $this->id,
            'branch'         => optional( $this->branch )->name,
            'section_enable' => $this->section_enable,
            'brand_enable'   => $this->brand_enable,
            'blog_enable'    => $this->blog_enable,
            'sections'       => $this->when( $this->section_enable == 1, HomeSectionResource::collection( $this->whenLoaded( 'sections' ) ) )
        ];
    }
}
