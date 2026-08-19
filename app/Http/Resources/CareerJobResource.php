<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CareerJobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                         => (string) $this->id,
            'slug'                       => $this->slug,
            'title'                      => $this->title,
            'department'                 => $this->department,
            'location'                   => $this->location,
            'type'                       => $this->type,
            'experience'                 => $this->experience,
            'posted'                     => optional($this->posted_at)->toDateString(),
            'summary'                    => $this->summary,
            'featured'                   => (bool) $this->featured,
            'image'                      => $this->mediaUrl($this->image),
            'serial_no'                  => $this->serial_no,
            'overview'                   => $this->overview,
            'application_deadline'       => optional($this->application_deadline)->toDateString(),
            'vacancy'                    => (int) $this->vacancy,
            'educational_qualifications' => $this->asList($this->educational_qualifications),
            'experience_details'         => $this->asList($this->experience_details),
            'responsibilities'           => $this->asList($this->responsibilities),
            'requirements'               => $this->asList($this->requirements),
            'nice_to_have'               => $this->asList($this->nice_to_have),
            'benefits'                   => $this->asList($this->benefits),
            'apply_email'                => $this->apply_email,
            'contact_phones'             => $this->asList($this->contact_phones),
            'application_instruction'    => $this->application_instruction,
        ];
    }

    private function asList(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map(fn ($item) => is_string($item) ? trim($item) : $item, $value)));
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $this->asList($decoded);
            }
        }

        return [];
    }

    private function mediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset($path);
    }
}
