<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogAuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'designation'     => $this->designation,
            'department'      => $this->department,
            'bio'             => $this->bio,
            'photo'           => $this->photo ? asset($this->photo) : null,
            'linkedin'        => $this->linkedin,
            'email'           => $this->email,
            'articles_count'  => $this->blogs_count ?? $this->blogs()->count(),
            'serial_no'       => $this->serial_no,
        ];
    }
}
