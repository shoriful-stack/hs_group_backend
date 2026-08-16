<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\PageResource;
use App\Models\Page;

class PageController extends BaseController
{
    public function index()
    {

        $pages = Page::with('language', 'branch')
        ->where('branch_id', getBranchByDomain()->id)
            ->paginate(20);

        $array = [
            'pages' => PageResource::collection($pages),
        ];
        return $this->sendResponse($array, 'Pages retrieved successfully.');
    }

    public function show($slug)
    {

        $pages = Page::with('language', 'branch')
            ->where('slug', $slug)->first();
        if (!$pages) {
            return $this->sendError('Page not found');
        }
        $array = [
            'page' => new PageResource($pages),
        ];
        return $this->sendResponse($array, 'Pages retrieved successfully.');
    }
}
