<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\ProductOriginsDataTable;
use App\Http\Requests\Product\ProductOriginRequest;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductOrigin;
use App\Services\SearchService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductOriginController extends Controller {
    public function index( ProductOriginsDataTable $dataTable ) {
        return $dataTable->render( 'productOrigin.index' );
    }

    public function create() {
        return view('productOrigin.create');
    }

    public function store( ProductOriginRequest $request ) {
        try {
            DB::beginTransaction();

            ProductOrigin::create( [
                'language_id' => $request->language_id,
                'name'        => $request->name,
                'serial'      => $request->serial,
            ] );

            DB::commit();
            return ReturnMessage::insertSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function edit( ProductOrigin $productOrigin ) {
        return view('productOrigin.edit', compact( 'productOrigin') );
    }

    public function update( ProductOriginRequest $request, ProductOrigin $productOrigin ) {
        try {
            DB::beginTransaction();

            $productOrigin->update( [
                'language_id' => $request->language_id,
                'name'        => $request->name,
                'serial'      => $request->serial,
                'status'      => $request->status,
            ] );

            DB::commit();
            return ReturnMessage::updateSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function destroy( ProductOrigin $productOrigin ) {
        $isUsed = Product::where('origin_id', $productOrigin->id)->exists();

        if($isUsed){
            return ReturnMessage::customMessage('error', 'Already in use, can not delete it!');
        }

        $productOrigin->delete();
        return ReturnMessage::deleteSuccess();
    }
    
    public function search(Request $request)
    {
        $results = (new SearchService)->search(ProductOrigin::class, $request);
        return response()->json($results);
    }
}
