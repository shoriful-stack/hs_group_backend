<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\Models\OurVision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OurVisionController extends Controller
{
    public function index()
    {
        $data = OurVision::query()->firstOrNew();
        return view('ourVision.index', compact('data'));
    }

    public function store(Request $request)
    {
        OurVision::updateOrCreate(
            ['branch_id' => Auth::user()->branch_id],
            [
                'title' => $request->title ?? 'N/A',
                'content'     => $request->contents ?? null,
                'language_id' => $request->language_id ?? 1,
            ]
        );

        Cache::forget('our_visions');

        return ReturnMessage::updateSuccess();
    }
}
