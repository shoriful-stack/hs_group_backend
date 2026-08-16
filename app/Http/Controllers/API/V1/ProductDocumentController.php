<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ProductDocumentResource;
use App\Models\ProductDocument;

class ProductDocumentController extends BaseController {
    public function index() {

        $product_documents = ProductDocument::with( 'language', 'branch', 'product' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'product_documents' => ProductDocumentResource::collection( $product_documents ),
        ];
        return $this->sendResponse( $array, 'Product Documents retrieved successfully.' );
    }
}
