<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\BlogCategoryResource;
use App\Models\BlogCategory;

class BlogCategoryController extends BaseController {
    public function index() {

        $blogCategories = BlogCategory::with( 'language', 'branch' )
            ->where( 'branch_id', getBranchByDomain()->id )
            ->paginate( 20 );

        $array = [
            'blogCategories' => BlogCategoryResource::collection( $blogCategories ),
        ];
        return $this->sendResponse( $array, 'Blog Categories retrieved successfully.' );
    }
}
