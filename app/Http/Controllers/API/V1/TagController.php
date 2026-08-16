<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends BaseController {
    public function index() {

        $tags = Tag::with( 'language', 'branch' )
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate( 20 );

        $array = [
            'tags' => TagResource::collection( $tags ),
        ];
        return $this->sendResponse( $array, 'Tags retrieved successfully.' );
    }
}
