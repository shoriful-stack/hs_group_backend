<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        $minutes = $this->reading_time ?: max(1, (int) ceil($wordCount / 200));
        $published = $this->published_at;
        $isDetail = $request->route('slug') !== null;

        return [
            'id'               => $this->id,
            'category'         => optional($this->category)->name,
            'category_slug'    => optional($this->category)->slug,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'excerpt'          => $this->excerpt,
            'summary'          => $this->summary,
            'content'          => $this->when($isDetail, $this->content),
            'image'            => $this->image ? asset($this->image) : null,
            'pdf_url'          => $this->pdf_file ? asset($this->pdf_file) : null,
            'featured'         => (bool) $this->featured,
            'views'            => (int) $this->views,
            'word_count'       => $wordCount,
            'reading_time'     => $minutes . ' min read',
            'date'             => optional($published)->toDateString(),
            'date_label'       => optional($published)->format('M j, Y'),
            'updated_date'     => optional($this->updated_at)->toDateString(),
            'updated_label'    => optional($this->updated_at)->format('M j, Y'),
            'author'           => new BlogAuthorResource($this->whenLoaded('author')),
            'tags'             => BlogTagResource::collection($this->whenLoaded('tags')),
            'seo_title'        => $this->seo_title,
            'seo_description'  => $this->seo_description,
            'seo_keywords'     => $this->seo_keywords,
            'serial_no'        => $this->serial_no,
            'status'           => $this->status,
            'published_at'     => $this->published_at,
            'created_at'       => $this->created_at,
            'created_by'       => optional($this->createdBy)->name,
            'updated_at'       => $this->updated_at,
        ];
    }
}
