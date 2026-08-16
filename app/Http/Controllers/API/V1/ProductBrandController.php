<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ProductBrandResource;
use App\Models\ProductBrand;

class ProductBrandController extends BaseController {
    public function index() {

        $productBrands = ProductBrand::with( 'branch' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'productBrands' => ProductBrandResource::collection( $productBrands ),
        ];
        return $this->sendResponse( $array, 'Product Brands retrieved successfully.' );
    }
}
