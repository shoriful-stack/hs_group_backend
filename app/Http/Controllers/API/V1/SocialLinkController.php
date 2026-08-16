<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\SocialLinkResource;
use App\Models\SocialLink;

class SocialLinkController extends BaseController {
    public function index() {

        $socialLinks = SocialLink::with( 'branch' )
        ->where('branch_id', getBranchByDomain()->id)
        ->select('id', 'branch_id', 'icon', 'link', 'serial_no')
        ->orderBy('serial_no', 'asc')
            ->get();

        $array = [
            'socialLinks' => SocialLinkResource::collection( $socialLinks ),
        ];
        return $this->sendResponse( $array, 'Social Links retrieved successfully.' );
    }
}
