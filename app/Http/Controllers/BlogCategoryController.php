<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\BlogCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogCategoryRequest;
use App\Enums\Status;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogCategoryController extends Controller {
    public function index( BlogCategoriesDataTable $dataTable ) {
        return $dataTable->render( 'blogCategory.index' );
    }

    public function create() {
        return view( 'blogCategory.create' );
    }

    public function store( BlogCategoryRequest $request ) {
        try {
            DB::beginTransaction();

            BlogCategory::create( [
                'name'            => $request->name,
                'language_id'     => 1,
                'serial_no'       => $request->serial_no,
                'status'          => Status::ACTIVE,
                'seo_title'       => $request->seo_title,
                'seo_description' => $request->seo_description,
                'seo_keywords'    => $request->seo_keywords,
            ] );

            DB::commit();
            return ReturnMessage::insertSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function edit( BlogCategory $blogCategory ) {
        return view( 'blogCategory.edit', compact( 'blogCategory' ) );
    }

    public function show( $id ) {
        //
    }

    public function update( BlogCategoryRequest $request, BlogCategory $blogCategory ) {
        try {
            DB::beginTransaction();

            $blogCategory->update( [
                'name'            => $request->name,
                'serial_no'       => $request->serial_no,
                'status'          => $request->status,
                'seo_title'       => $request->seo_title,
                'seo_description' => $request->seo_description,
                'seo_keywords'    => $request->seo_keywords,
            ] );

            DB::commit();
            return ReturnMessage::updateSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function destroy( BlogCategory $blogCategory ) {
        try{
            $isUsed = Blog::where('category_id', $blogCategory->id)->exists();

            if($isUsed){
                return ReturnMessage::customMessage('error', 'Already in use, can not delete it!');
            }
            
            $blogCategory->delete();
            return ReturnMessage::deleteSuccess();
        } catch(QueryException $e){
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    
    public function search(Request $request)
    {
        try {
            $blogCategory = BlogCategory::query()
                ->active()
                ->when($request->q, function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                })
                ->select('id', 'name')
                ->limit(20)
                ->get();

            return response()->json($blogCategory);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Sorry! not found'], 404);
        }
    }
}
