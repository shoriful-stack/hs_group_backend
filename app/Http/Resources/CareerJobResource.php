<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CareerJobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isDetail = $request->route('slug') === $this->slug;

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
            'overview'                   => $this->when($isDetail, $this->overview),
            'application_deadline'       => $this->when($isDetail, optional($this->application_deadline)->toDateString()),
            'vacancy'                    => $this->when($isDetail, (int) $this->vacancy),
            'educational_qualifications' => $this->when($isDetail, $this->educational_qualifications ?? []),
            'experience_details'         => $this->when($isDetail, $this->experience_details ?? []),
            'responsibilities'           => $this->when($isDetail, $this->responsibilities ?? []),
            'requirements'               => $this->when($isDetail, $this->requirements ?? []),
            'nice_to_have'               => $this->when($isDetail, $this->nice_to_have ?? []),
            'benefits'                   => $this->when($isDetail, $this->benefits ?? []),
            'apply_email'                => $this->when($isDetail, $this->apply_email),
            'contact_phones'             => $this->when($isDetail, $this->contact_phones ?? []),
            'application_instruction'    => $this->when($isDetail, $this->application_instruction),
        ];
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
