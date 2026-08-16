<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\AwardDataTable;
use App\Http\Requests\AwardRequest;
use App\Models\Award;
use App\Models\Language;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AwardController extends Controller {
    public function index( AwardDataTable $dataTable ) {
        return $dataTable->render( 'award.index' );
    }

    public function create() {
        return view( 'award.create' );
    }

    public function store( AwardRequest $request ) {
        try {
            DB::beginTransaction();

            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    uniqid(),
                    'award'
                );
            }

            $award = new Award();
            $award->language_id = $request->language_id ?? 1;
            $award->title = $request->title ?? '';
            $award->content = $request->contents ?? '';
            $award->image = $image ?? null;
            $award->save();

            Cache::forget('awards');
            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function edit( Award $award ) {
        return view( 'award.edit', compact( 'award' ) );
    }

    public function update( AwardRequest $request, Award $award ) {
        try {
            DB::beginTransaction();

            $image = $award->image;

            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    uniqid(),
                    'award',
                    $award->image
                );
            }

            $award->language_id = $request->language_id ?? 1;
            $award->title = $request->title ?? '';
            $award->content = $request->contents ?? '';
            $award->image = $image;
            $award->status = $request->status;
            $award->save();

            Cache::forget('awards');
            
            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function destroy( Award $award ) {
        try {
            $award->delete();
            Cache::forget('awards');
            return ReturnMessage::deleteSuccess();
        } catch ( QueryException $e ) {
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }
}
