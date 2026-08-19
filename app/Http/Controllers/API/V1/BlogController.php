<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\BlogAuthorResource;
use App\Http\Resources\BlogCategoryResource;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\BlogAuthor;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends BaseController
{
    public function index(Request $request)
    {
        $blogs = Blog::with(['category', 'tags', 'author' => fn($q) => $q->withCount('blogs')])
            ->published();

        if ($request->filled('category')) {
            $blogs->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        }

        if ($request->filled('tag')) {
            $blogs->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->get('tag'));
            });
        }

        if ($request->boolean('featured')) {
            $blogs->where('featured', true);
        }

        if ($request->boolean('exclude_featured')) {
            $blogs->where('featured', false);
        }

        if ($request->filled('q')) {
            $q = $request->get('q');
            $blogs->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%");
            });
        }

        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $blogs->orderBy('published_at');
        } elseif ($sort === 'popular') {
            $blogs->orderByDesc('views');
        } else {
            $blogs->orderByDesc('published_at');
        }

        if ($request->filled('limit')) {
            $items = $blogs->limit((int) $request->limit)->get();

            return $this->sendResponse([
                'blogs' => BlogResource::collection($items),
            ], 'Blogs retrieved successfully.');
        }

        $perPage = $request->get('per_page', 10);
        $paginated = $blogs->paginate($perPage);

        return $this->sendResponse([
            'blogs'        => BlogResource::collection($paginated),
            'totalResults' => $paginated->total(),
            'currentPage'  => $paginated->currentPage(),
            'totalPages'   => $paginated->lastPage(),
        ], 'Blogs retrieved successfully.');
    }

    public function categories()
    {
        $categories = BlogCategory::active()
            ->orderBy('serial_no')
            ->get();

        return $this->sendResponse([
            'categories' => BlogCategoryResource::collection($categories),
        ], 'Blog categories retrieved successfully.');
    }

    public function authors()
    {
        $authors = BlogAuthor::withCount('blogs')
            ->active()
            ->orderBy('serial_no')
            ->get();

        return $this->sendResponse([
            'authors' => BlogAuthorResource::collection($authors),
        ], 'Blog authors retrieved successfully.');
    }

    public function show($slug)
    {
        $blog = Blog::with(['language', 'category', 'tags', 'author' => fn($q) => $q->withCount('blogs')])
            ->published()
            ->where('slug', $slug)
            ->first();

        if (!$blog) {
            return $this->sendError('Blog not found');
        }

        $blog->increment('views');

        $prev = Blog::published()
            ->where('published_at', '<', $blog->published_at)
            ->orderByDesc('published_at')
            ->first(['id', 'title', 'slug', 'image', 'published_at']);

        $next = Blog::published()
            ->where('published_at', '>', $blog->published_at)
            ->orderBy('published_at')
            ->first(['id', 'title', 'slug', 'image', 'published_at']);

        $related = Blog::with('category', 'author')
            ->published()
            ->where('id', '!=', $blog->id)
            ->when($blog->category_id, fn($q) => $q->where('category_id', $blog->category_id))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $recent = Blog::with('category')
            ->published()
            ->where('id', '!=', $blog->id)
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        $popular = Blog::with('category')
            ->published()
            ->where('id', '!=', $blog->id)
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        return $this->sendResponse([
            'blog'     => new BlogResource($blog),
            'prev'     => $prev ? new BlogResource($prev) : null,
            'next'     => $next ? new BlogResource($next) : null,
            'related'  => BlogResource::collection($related),
            'recent'   => BlogResource::collection($recent),
            'popular'  => BlogResource::collection($popular),
        ], 'Blogs retrieved successfully.');
    }
}
