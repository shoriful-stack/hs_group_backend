<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\PrivacyPolicyResource;
use App\Models\PrivacyPolicy;

class PrivacyPolicyController extends BaseController
{
        public function index() {

        $privacyPolicies = PrivacyPolicy::with( 'language', 'branch' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'privacyPolicies' => PrivacyPolicyResource::collection( $privacyPolicies ),
        ];
        return $this->sendResponse( $array, 'Privacy Policies retrieved successfully.' );
    }
}
