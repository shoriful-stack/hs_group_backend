<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\BlogAuthorDataTable;
use App\Http\Requests\Blog\BlogAuthorRequest;
use App\Models\Blog;
use App\Models\BlogAuthor;
use App\Models\Language;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogAuthorController extends Controller
{
    public function index(BlogAuthorDataTable $dataTable)
    {
        return $dataTable->render('blogAuthor.index');
    }

    public function create()
    {
        $languages = Language::where('status', 1)->pluck('name', 'id');
        return view('blogAuthor.create', compact('languages'));
    }

    public function store(BlogAuthorRequest $request)
    {
        try {
            DB::beginTransaction();

            $photo = null;
            if ($request->hasFile('photo')) {
                $photo = Helper::imageUpload($request->file('photo'), uniqid(), 'blog/authors');
            }

            BlogAuthor::create([
                'language_id' => $request->language_id,
                'name'        => $request->name,
                'designation' => $request->designation,
                'department'  => $request->department,
                'bio'         => $request->bio,
                'linkedin'    => $request->linkedin,
                'email'       => $request->email,
                'photo'       => $photo,
                'serial_no'   => $request->serial_no,
            ]);

            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(BlogAuthor $blogAuthor)
    {
        $languages = Language::where('status', 1)->pluck('name', 'id');
        return view('blogAuthor.edit', compact('blogAuthor', 'languages'));
    }

    public function update(BlogAuthorRequest $request, BlogAuthor $blogAuthor)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('photo')) {
                $blogAuthor->photo = Helper::imageUpload(
                    $request->file('photo'),
                    uniqid(),
                    'blog/authors',
                    $blogAuthor->photo
                );
            }

            $blogAuthor->update([
                'language_id' => $request->language_id,
                'name'        => $request->name,
                'designation' => $request->designation,
                'department'  => $request->department,
                'bio'         => $request->bio,
                'linkedin'    => $request->linkedin,
                'email'       => $request->email,
                'photo'       => $blogAuthor->photo,
                'serial_no'   => $request->serial_no,
                'status'      => $request->status,
            ]);

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(BlogAuthor $blogAuthor)
    {
        try {
            if (Blog::where('author_id', $blogAuthor->id)->exists()) {
                return ReturnMessage::customMessage('error', 'Already in use, can not delete it!');
            }

            $blogAuthor->delete();
            return ReturnMessage::deleteSuccess();
        } catch (QueryException $e) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $authors = BlogAuthor::query()
                ->when($request->q, function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                })
                ->select('id', 'name')
                ->limit(20)
                ->get();

            return response()->json($authors);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Sorry! not found'], 404);
        }
    }
}
