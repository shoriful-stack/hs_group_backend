<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ProductVideoResource;
use App\Models\ProductVideo;

class ProductVideoController extends BaseController {
    public function index() {

        $product_videos = ProductVideo::with( 'language', 'branch', 'product' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'product_videos' => ProductVideoResource::collection( $product_videos ),
        ];
        return $this->sendResponse( $array, 'Product Videos retrieved successfully.' );
    }
}
