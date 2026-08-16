<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ProductFeatureResource;
use App\Models\ProductFeature;

class ProductFeatureController extends BaseController {
    public function index() {

        $product_features = ProductFeature::with( 'language', 'branch', 'product' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'product_features' => ProductFeatureResource::collection( $product_features ),
        ];
        return $this->sendResponse( $array, 'Product Features retrieved successfully.' );
    }
}
