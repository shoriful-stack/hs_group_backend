<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\MessagingResource;
use App\Models\Messaging;

class MessagingController extends BaseController
{
    public function index()
    {

        $messagings = Messaging::with('branch')
            ->where('branch_id', getBranchByDomain()->id)
            ->paginate(20);

        $array = [
            'messagings' => MessagingResource::collection($messagings),
        ];
        return $this->sendResponse($array, 'Messaging Icon retrieved successfully.');
    }
}
