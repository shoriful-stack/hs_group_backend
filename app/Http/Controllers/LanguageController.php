<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\LanguagesDataTable;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use App\Services\SearchService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller 
{
    public function index( LanguagesDataTable $dataTable ) {
        return $dataTable->render( 'language.index' );
    }

    public function create() {
        return view('language.create');
    }

    public function store( LanguageRequest $request ) {
        try {
            DB::beginTransaction();

            Language::create( [
                'name'       => $request->name,
                'code'       => $request->code,
                'direction'  => $request->direction,
                'is_default' => $request->is_default,
            ] );

            DB::commit();
            return ReturnMessage::insertSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function edit( Language $language ) {
        return view( 'language.edit', compact( 'language' ) );
    }

    public function update( LanguageRequest $request, Language $language ) {
        try {
            DB::beginTransaction();

            $language->update( [
                'name'       => $request->name,
                'code'       => $request->code,
                'direction'  => $request->direction,
                'is_default' => $request->is_default,
                'status'     => $request->status,
            ] );

            DB::commit();
            return ReturnMessage::updateSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function destroy( Language $language ) {
        $language->delete();
        return ReturnMessage::deleteSuccess();
    }
    
    public function search(Request $request)
    {
        $results = (new SearchService)->search(Language::class, $request);
        return response()->json($results);
    }
}
