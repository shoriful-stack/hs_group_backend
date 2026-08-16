<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ProductOriginResource;
use App\Models\ProductOrigin;

class ProductOriginController extends BaseController {
    public function index() {

        $productOrigins = ProductOrigin::with( 'language', 'branch' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'productOrigins' => ProductOriginResource::collection( $productOrigins ),
        ];
        return $this->sendResponse( $array, 'Product Origins retrieved successfully.' );
    }
}
