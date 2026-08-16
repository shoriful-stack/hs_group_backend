<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\BlogDataTable;
use App\Http\Requests\Blog\BlogRequest;
use App\Models\Blog;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller {
    public function index( BlogDataTable $dataTable ) {
        return $dataTable->render( 'blog.index' );
    }

    public function create() {
        return view( 'blog.create' );
    }

    public function store( BlogRequest $request ) {
        // return $request;
        try {
            DB::beginTransaction();
            $image = '';
            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    uniqid(),
                    'blog',
                );
            }

            $blog = new Blog();

            $blog->title = $request->title;
            $blog->language_id = $request->language_id;
            $blog->category_id = $request->category_id;
            $blog->content = $request->contents;
            $blog->image = $image;
            $blog->seo_title = $request->seo_title;
            $blog->seo_description = $request->seo_description;
            $blog->seo_keywords = $request->seo_keywords;
            $blog->serial_no = $request->serial_no;
            $blog->status = $request->status;
            // $request->status == BlogStatus::PUBLISHED ? $blog->published_at = Carbon::now() : null;
            $blog->published_at = $request->published_at;
            $blog->save();

            // Prepare pivot data for tags
            $pivotData = [];
            foreach ( $request->tag_id as $key => $tagId ) {
                $pivotData[$tagId] = [
                    'language_id' => $request->language_id,
                    'serial_no'   => $request->serial_no ?? 1,
                    'created_by'  => Auth::user()->id,
                    'updated_by'  => Auth::user()->id,
                ];
            }

            // Attach tags
            $blog->tags()->sync( $pivotData );

            DB::commit();
            return redirect()->route( 'blogs.index' )->with( 'success', 'Blog created successfully!' );
        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function edit( Blog $blog ) {
        return view( 'blog.edit', compact( 'blog' ) );
    }

    public function update( BlogRequest $request, Blog $blog ) {
        try {
            DB::beginTransaction();

            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    uniqid(),
                    'blog'
                );
                $blog->image = $image;
            }

            $blog->title = $request->title;
            $blog->language_id = $request->language_id;
            $blog->category_id = $request->category_id;
            $blog->content = $request->contents;
            $blog->seo_title = $request->seo_title;
            $blog->seo_description = $request->seo_description;
            $blog->seo_keywords = $request->seo_keywords;
            $blog->serial_no = $request->serial_no;
            $blog->status = $request->status;
            $blog->published_at = $request->published_at ? \Carbon\Carbon::parse( $request->published_at ) : null;

            $blog->save();

            $pivotData = [];
            if ( $request->has( 'tag_id' ) && is_array( $request->tag_id ) ) {
                foreach ( $request->tag_id as $tagId ) {
                    $pivotData[$tagId] = [
                        'language_id' => $request->language_id,
                        'serial_no'   => $request->serial_no ?? 1,
                        'created_by'  => Auth::user()->id,
                        'updated_by'  => Auth::user()->id,
                    ];
                }
            }

            $blog->tags()->sync( $pivotData );

            DB::commit();

            return redirect()->route( 'blogs.index' )->with( 'success', 'Blog updated successfully.' );
        } catch ( \Exception $e ) {
            DB::rollBack();
            return redirect()->route('blogs.index')->with( 'error', $e->getMessage() );
        }
    }

    public function destroy( Blog $blog ) {
        // $blog->delete();
        // return ReturnMessage::deleteSuccess();
    }
}
