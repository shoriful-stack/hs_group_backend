<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDocumentResource extends JsonResource {
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
            'attachment' => asset( $this->attachment ),
            'link'       => $this->link,
            'type'       => $this->type,
        ];
    }
}
