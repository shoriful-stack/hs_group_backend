<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsEventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $upcoming = $this->isUpcoming();
        $image = $this->image;
        if ($image && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://')) {
            $image = asset($image);
        }

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'date'        => optional($this->event_date)->toDateString(),
            'date_label'  => optional($this->event_date)->format('M j, Y'),
            'location'    => $this->location,
            'status'      => $upcoming ? 'upcoming' : 'past',
            'image'       => $image,
            'cta'         => [
                'label' => $this->cta_label ?: ($upcoming ? 'Register Interest' : 'View Coverage'),
                'href'  => $this->cta_href ?: ($upcoming ? '/contact' : '/blog'),
            ],
            'serial_no'   => $this->serial_no,
        ];
    }
}
