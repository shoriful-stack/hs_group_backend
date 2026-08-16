<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( Request $request ): array {
        return [
            'id'               => $this->id,
            'type'             => $this->type->value,
            'branch'           => optional( $this->branch )->name,
            'language'         => optional( $this->language )->name,
            'name'             => $this->name,
            'slug'             => $this->slug,
            'thumb_image'      => asset( $this->thumb_image ),
            'background_image' => asset( $this->background_image ),
            'details'          => $this->details,
            'serial'           => $this->serial,
            'seo_title'        => $this->seo_title,
            'seo_description'  => $this->seo_description,
            'seo_keywords'     => $this->seo_keywords,
            'status'           => $this->status,
            'category'         => $this->whenLoaded( 'productCategory', function () {
                return [
                    'name' => $this->productCategory->name,
                    'slug' => $this->productCategory->slug,
                ];
            } ),
            'brand'            => $this->whenLoaded( 'productBrand', function () {
                return [
                    'name' => $this->productBrand->name,
                    'slug' => $this->productBrand->slug,
                ];
            } ),

            'origin'           => $this->whenLoaded( 'productOrigin', function () {
                return [
                    'name' => $this->productOrigin->name,
                    'slug' => $this->productOrigin->slug,
                ];
            } ),
            'features'         => ProductFeatureResource::collection( $this->whenLoaded( 'productFeatures' ) ),
            'videos'           => ProductVideoResource::collection( $this->whenLoaded( 'productVideos' ) ),
            'documents'        => ProductDocumentResource::collection( $this->whenLoaded( 'productDocuments' ) )
        ];
    }
}
