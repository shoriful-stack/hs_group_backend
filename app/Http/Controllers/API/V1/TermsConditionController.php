<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\TermsConditionResource;
use App\Models\TermsCondition;

class TermsConditionController extends BaseController {
    public function index() {

        $terms_conditions = TermsCondition::with( 'language', 'branch' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'terms_conditions' => TermsConditionResource::collection( $terms_conditions ),
        ];
        return $this->sendResponse( $array, 'Terms & Conditions retrieved successfully.' );
    }
}
