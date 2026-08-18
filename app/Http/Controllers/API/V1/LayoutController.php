<?php

namespace App\Http\Controllers\API\V1;

use App\Services\LayoutDataService;

class LayoutController
{
    public function __construct(private readonly LayoutDataService $layoutData) {}

    public function show()
    {
        return response()->json([
            'success' => true,
            'data'    => $this->layoutData->get(),
        ], 200);
    }
}
