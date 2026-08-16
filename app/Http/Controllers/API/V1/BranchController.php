<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\BranchResource;
use App\Models\Branch;

class BranchController extends BaseController {
    public function index() {

        $branches = Branch::query()
        ->where('is_default',0)
        ->where('status', 1)
        ->orderBy('serial')
        ->paginate( 20 );

        $array = [
            'branches' => BranchResource::collection( $branches ),
        ];
        return $this->sendResponse( $array, 'Branches retrieved successfully.' );
    }

    public function getBranch() {

        $branches = Branch::query()
        ->where('id',getBranchByDomain()->id)
        ->first();

        return $this->sendResponse( [
            'branch'=>new BranchResource( $branches )
        ], 
        'API retrieved successfully.' );
    }
}
