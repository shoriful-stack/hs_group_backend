<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\BlogDataTable;
use App\Http\Requests\Blog\BlogRequest;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('blog.index');
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(BlogRequest $request, BlogService $blogService)
    {
        try {
            DB::beginTransaction();
            $blogService->createOrUpdate($request);
            DB::commit();

            return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(Blog $blog)
    {
        $blog->load(['tags', 'author', 'category', 'language']);
        return view('blog.edit', compact('blog'));
    }

    public function update(BlogRequest $request, Blog $blog, BlogService $blogService)
    {
        try {
            DB::beginTransaction();
            $blogService->createOrUpdate($request, $blog);
            DB::commit();

            return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('blogs.index')->with('error', $e->getMessage());
        }
    }

    public function destroy(Blog $blog)
    {
        try {
            $blog->tags()->detach();
            $blog->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
