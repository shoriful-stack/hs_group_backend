<?php

namespace App\Services;

use App\CustomClass\Helper;
use App\Http\Requests\Blog\BlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogService
{
    public function createOrUpdate(BlogRequest $request, ?Blog $blog = null): Blog
    {
        $blog ??= new Blog();

        if ($request->hasFile('image')) {
            $blog->image = Helper::imageUpload(
                $request->file('image'),
                uniqid(),
                'blog',
                $blog->exists ? $blog->image : null
            );
        }

        if ($request->hasFile('pdf_file')) {
            $blog->pdf_file = Helper::documentUpload(
                $request->file('pdf_file'),
                uniqid(),
                'blog/pdf',
                $blog->exists ? $blog->pdf_file : null
            );
        }

        $blog->title = $request->title;
        $blog->language_id = $request->language_id;
        $blog->category_id = $request->category_id;
        $blog->author_id = $request->author_id;
        $blog->excerpt = $request->excerpt;
        $blog->summary = $request->summary;
        $blog->content = $request->contents;
        $blog->seo_title = $request->seo_title;
        $blog->seo_description = $request->seo_description;
        $blog->seo_keywords = $request->seo_keywords;
        $blog->serial_no = $request->serial_no;
        $blog->status = $request->status;
        $blog->featured = $request->boolean('featured');
        $blog->reading_time = $request->reading_time;
        $blog->published_at = $request->published_at
            ? \Carbon\Carbon::parse($request->published_at)
            : null;
        $blog->save();

        if ($blog->featured) {
            Blog::query()
                ->where('id', '!=', $blog->id)
                ->where('featured', true)
                ->update(['featured' => false]);
        }

        $pivotData = [];
        foreach ($request->input('tag_id', []) as $tagId) {
            $pivotData[$tagId] = [
                'language_id' => $request->language_id,
                'serial_no'   => $request->serial_no ?? 1,
                'created_by'  => Auth::id(),
                'updated_by'  => Auth::id(),
            ];
        }
        $blog->tags()->sync($pivotData);

        return $blog;
    }
}
