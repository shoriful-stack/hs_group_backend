<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\TagDataTable;
use App\Http\Requests\TagRequest;
use App\Models\BlogTag;
use App\Models\Language;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller {
    public function index( TagDataTable $dataTable ) {
        return $dataTable->render( 'tag.index' );
    }

    public function create() {
        $languages = Language::where( 'status', 1 )->pluck( 'name', 'id' );
        return view( 'tag.create', compact( 'languages' ) );
    }

    public function store( TagRequest $request ) {
        try {
            DB::beginTransaction();

            Tag::create( [
                'language_id' => $request->language_id,
                'name'        => $request->name,
                'serial_no'   => $request->serial_no,
            ] );

            DB::commit();
            return ReturnMessage::insertSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function edit( Tag $tag ) {
        $languages = Language::where( 'status', 1 )->pluck( 'name', 'id' );
        return view( 'tag.edit', compact( 'tag', 'languages' ) );
    }

    public function update( TagRequest $request, Tag $tag ) {
        try {
            DB::beginTransaction();

            $tag->update( [
                'language_id' => $request->language_id,
                'name'        => $request->name,
                'serial_no'   => $request->serial_no,
                'status'      => $request->status,
            ] );

            DB::commit();
            return ReturnMessage::updateSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function destroy( Tag $tag ) {
        try{
            $isUsed = BlogTag::where('tag_id', $tag->id)->exists();

            if($isUsed){
                return ReturnMessage::customMessage('error', 'Already in use, can not delete it!');
            }

            $tag->delete();
            return ReturnMessage::deleteSuccess();
        } catch(QueryException $e){
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $tags = Tag::query()
                ->when($request->q, function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                })
                ->select('id', 'name')
                ->limit(20)
                ->get();

            return response()->json($tags);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Sorry! not found'], 404);
        }
    }
}
