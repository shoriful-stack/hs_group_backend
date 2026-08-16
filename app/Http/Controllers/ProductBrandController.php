<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\ProductBrandsDataTable;
use App\Http\Requests\Product\ProductBrandRequest;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Services\SearchService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBrandController extends Controller {
    public function index( ProductBrandsDataTable $dataTable ) {
        return $dataTable->render( 'productBrand.index' );
    }

    public function create() {
        return view( 'productBrand.create');
    }

    public function store( ProductBrandRequest $request ) {
        try {
            DB::beginTransaction();

            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    uniqid(),
                    'product_brands'
                );
            } else {
                $image = '/assets/images/default-brand.png';
            }

            ProductBrand::create( [
                'language_id' => $request->language_id,
                'name'        => $request->name,
                'serial'      => $request->serial,
                'image'       => $image,
            ] );

            DB::commit();
            return ReturnMessage::insertSuccess();

        } catch ( QueryException $e ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function edit( ProductBrand $productBrand ) {
        return view('productBrand.edit', compact('productBrand'));
    }

    public function update( ProductBrandRequest $request, ProductBrand $productBrand ) {
        try {
            DB::beginTransaction();

            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    uniqid(),
                    'product_brands',
                    $productBrand->image
                );
                $productBrand->image = $image;
            }

            $productBrand->update( [
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

    public function destroy( ProductBrand $productBrand ) {
        $isUsed = Product::where('brand_id', $productBrand->id)->exists();

        if($isUsed){
            return ReturnMessage::customMessage('error', 'Already in use, can not delete it!');
        }

        $productBrand->delete();
        return ReturnMessage::deleteSuccess();
    }
    
    public function search(Request $request)
    {
        $results = (new SearchService)->search(ProductBrand::class, $request);
        return response()->json($results);
    }
}
