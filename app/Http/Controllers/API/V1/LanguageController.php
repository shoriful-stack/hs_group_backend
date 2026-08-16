<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\LanguageResource;
use App\Models\Language;

class LanguageController extends BaseController
{
        public function index() {
            $languages = Language::paginate(20);

        $array=[
            'languages' => LanguageResource::collection($languages),
        ];
        return $this->sendResponse($array, 'Languages retrieved successfully.');
    }
}
