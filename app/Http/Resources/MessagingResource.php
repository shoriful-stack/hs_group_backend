<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagingResource extends JsonResource
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
            'icon'       => $this->icon,
            'link'       => $this->link,
            'serial_no'  => $this->serial_no,
            'status'     => $this->status,
        ];
    }
}
